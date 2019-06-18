#!/bin/bash
BACKUP_NAME=""
iv_editConfigurations(){
    iv_info "Configuration Editor" "Scanning for contents ..."
	let i=0
	W=()
	C=()
	while read -r line; do
	    let i=$i+1
	    W+=($i "$line")
	    C[$i]=$line

	done < <( find ./ -type f \( -iname \*.ini -o -iname \*.json \) -printf "%p\n" )
	FILE=$(dialog --backtitle "Intellivoid Technologies" --title "Intellivoid Toolkit" --menu "Edit a configuration file" 24 80 57 "${W[@]}" 3>&2 2>&1 1>&3) # show dialog and store output
	clear
	if [ $FILE > 0 ]; then
		nano ${C[$FILE]}
		iv_editConfigurations
		return
	fi

	iv_mainMenu
}

iv_getInput(){
	DIALOG=${DIALOG=dialog}
	tempfile=`tempfile 2>/dev/null` || tempfile=/tmp/test$$
	trap "rm -f $tempfile" 0 1 2 5 15

	$DIALOG --backtitle "Intellivoid Technologies" --clear \
	        --inputbox "$1" 16 51 2> $tempfile

	retval=$?

	case $retval in
	  0)
	    retval=`cat $tempfile`;;
	  1)
	    exit;;
	  255)
	    if test -s $tempfile ; then
	      retval=$tempfile
	    else
	      echo "ESC pressed."
	    fi
	    ;;
	esac
}
iv_display_text(){
DIALOG=${DIALOG=dialog}
tempfile=`tempfile 2>/dev/null` || tempfile=/tmp/test$$
trap "rm -f $tempfile" 0 1 2 5 15


TEXT=$2
test -f $TEXT || TEXT=../COPYING

cat $TEXT | expand >> $tempfile

$DIALOG --clear --backtitle "Intellivoid Technologies" --title "$1" --textbox "$tempfile" 22 77
}
iv_get_ssh_key(){
    if [ -f "$HOME/.ssh/iv_toolkit" ]; then
        iv_display_text "$HOME/.ssh/iv_toolkit" "$HOME/.ssh/iv_toolkit"
        iv_display_text "$HOME/.ssh/iv_toolkit.pub" "$HOME/.ssh/iv_toolkit.pub"
        iv_mainMenu
		return
	else
	    iv_getInput "There is no SSH Key for IV_TOOLKIT, if you want to generate one type YES"
		CONFIRMATION=$retval
		if [ "$CONFIRMATION" != "YES" ]; then
			iv_mainMenu
			return
		fi
		iv_getInput "Enter your staff email"
        STAFF_EMAIL=$retval
        iv_getInput "Enter a password"
        PASSWORD=$retval
        iv_info "SSH Agent" "Creating SSH Key ..."
		ssh-keygen -t rsa -b 4096 -C "$STAFF_EMAIL" -P "$PASSWORD" -f "$HOME/.ssh/iv_toolkit" -q
		iv_alert "SSH Agent" "The SSH Key has been created!"
		iv_get_ssh_key
		return
    fi

}
iv_banner(){



printf "   /###### /##   /## /######## /######## /##       /##       /###### /##    /##  /######  /###### /####### \n"
printf "  |_  ##_/| ### | ##|__  ##__/| ##_____/| ##      | ##      |_  ##_/| ##   | ## /##__  ##|_  ##_/| ##__  ##\n"
printf "    | ##  | ####| ##   | ##   | ##      | ##      | ##        | ##  | ##   | ##| ##  \ ##  | ##  | ##  \ ##\n"
printf "    | ##  | ## ## ##   | ##   | #####   | ##      | ##        | ##  |  ## / ##/| ##  | ##  | ##  | ##  | ##\n"
printf "    | ##  | ##  ####   | ##   | ##__/   | ##      | ##        | ##   \  ## ##/ | ##  | ##  | ##  | ##  | ##\n"
printf "    | ##  | ##\  ###   | ##   | ##      | ##      | ##        | ##    \  ###/  | ##  | ##  | ##  | ##  | ##\n"
printf "   /######| ## \  ##   | ##   | ########| ########| ######## /######   \  #/   |  ######/ /######| #######/\n"
printf "  |______/|__/  \__/   |__/   |________/|________/|________/|______/    \_/     \______/ |______/|_______/ \n"

}
iv_alert(){
	#!/bin/sh
	DIALOG=${DIALOG=dialog}

	$DIALOG --backtitle "Intellivoid Technologies" --title "$1" --clear \
	        --msgbox "$2" 10 41

}
iv_runphp_backup(){
read -r -d '' BNRPHP << EOM
\$it = new RecursiveDirectoryIterator(__DIR__);
\$configuration_files = array();
foreach(new RecursiveIteratorIterator(\$it) as \$file)
{
	\$fnsi = pathinfo(\$file, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo(\$file, PATHINFO_BASENAME);
	if(pathinfo(\$file, PATHINFO_EXTENSION) == 'ini')
	{
		\$configuration_files[\$fnsi] = file_get_contents(\$fnsi);
	}
	if(pathinfo(\$file, PATHINFO_EXTENSION) == 'json')
	{
		\$configuration_files[\$fnsi] = file_get_contents(\$fnsi);
	}
}
\$backup_img = json_encode(\$configuration_files, JSON_PRETTY_PRINT);
file_put_contents("$1.imgc", \$backup_img);
EOM
php -r "$BNRPHP";
}

iv_proc_choice(){
	case $choice in
		IV_EC)
			iv_editConfigurations;;
		INST)
			iv_install;;
		BACK)
			iv_backup;;
		R_UPDATE)
		    iv_r_update;;
		SSH)
		    iv_get_ssh_key;;
		SYNC)
		    iv_git_sync;;
		BASH)
		    clear;
		    iv_banner;
		    bash;
		    iv_mainMenu;;
		EXIT)
			clear
			exit;;
	esac
}

iv_info(){
	$DIALOG --backtitle "Intellivoid Technologies" --title "$1" --infobox "$2" 10 52
}
iv_git_sync(){
    iv_getInput "Enter repo name to sync"
	REPO_NAME=$retval
	clear
	if [ -d $REPO_NAME ]; then
	    ssh-agent bash -c "ssh-add $HOME/.ssh/iv_toolkit; git -C "$REPO_NAME" pull"
	else
        ssh-agent bash -c "ssh-add $HOME/.ssh/iv_toolkit; git -C git@github.com:intellivoid/$REPO_NAME.git"
	fi
	iv_alert "Git Sync" "The repo has been synced successfully"
	iv_mainMenu
}
iv_install(){
	if [ -d "src" ]; then
		iv_getInput "Destination Directory"
		DESTINATION=$retval

		if [ -d "$DESTINATION" ]; then
			iv_getInput "The directory $DESTINATION will be deleted and overwritten, type YES to confirm"
			CONFIRMATION=$retval
			if [ "$CONFIRMATION" == "YES" ]; then
				iv_info "Installer" "Deleting $DESTINATION"
				rm -rf $DESTINATION
			else
				iv_alert "Installer" "The installation will not continue since you chose that $DESTINATION cannot be deleted"
				iv_mainMenu
				return
			fi
		else
			iv_getInput "The installer will install from source to $DESTINATION, type YES to confirm"
			CONFIRMATION=$retval
			if [ "$CONFIRMATION" != "YES" ]; then
				iv_alert "Installer" "The installation will not continue"
				iv_mainMenu
				return
			fi
		fi

		iv_info "Installer" "Creating directory $DESTINATION"
		mkdir $DESTINATION
		iv_info "Installer" "Installing contents from source"
		cp -r src/. "$DESTINATION"
		iv_alert "Installer" "The installation has been completed and the source contents has been copied over to $DESTINATION"

	else
		iv_alert "Installer" "No source directory was found"
	fi

	iv_mainMenu
}
iv_backup(){
	iv_getInput "Enter a name for this backup"
	BACKUP_NAME=$retval
	if [ "$BACKUP_NAME" == "" ]; then
	    iv_mainMenu
		return
	fi
	iv_info "Backup Configuration Files" "Running Backup Process"
	iv_runphp_backup "$BACKUP_NAME"
	iv_alert "Backup Configuration Files" "Backup done! File created $BACKUP_NAME.imgc"
	iv_mainMenu
}
iv_r_update(){
    clear
	apt-get update
	apt-get -y upgrade
	iv_alert "System Update" "Update Completed"
	iv_mainMenu
}
iv_mainMenu(){
	DIALOG=${DIALOG=dialog}
	tempfile=`tempfile 2>/dev/null` || tempfile=/tmp/test$$
	trap "rm -f $tempfile" 0 1 2 5 15

	$DIALOG --clear --title "Intellivoid Toolkit" --backtitle "Intellivoid Technologies" \
	        --menu "Choose an action" 20 51 15 \
	        "IV_EC" "Edit configuration Files" \
	        "INST"  "Installs/Updates a Service from Source" \
	        "BACK"  "Backup json & ini files to a single .cimg file" \
	        "SSH"  "Views the IV_TOOLKIT SSH Key" \
	        "R_UPDATE" "Updates the system" \
	        "R_INST"  "Installs a system dependency (Setup)" \
	        "SYNC" "Syncs a git repo" \
	        "BASH" "Invoke bash instance" \
	        "EXIT"  "Exits this Program" 2> $tempfile

	retval=$?

	choice=`cat $tempfile`

	case $retval in
	  0)
		iv_proc_choice $choice;;
	  1)
	    clear;
	    exit;;
	  255)
	    clear;
	    exit;;
	esac
}
if (( $EUID != 0 )); then
    iv_alert "Permissions Required" "This setup requires root"
else
    iv_mainMenu;
fi