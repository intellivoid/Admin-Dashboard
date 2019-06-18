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
		EXIT)
			clear
			exit;;
	esac
}

iv_info(){
	$DIALOG --backtitle "Intellivoid Technologies" --title "$1" --infobox "$2" 10 52
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
	        --menu "Intellivoid Toolkit" 20 51 15 \
	        "IV_EC" "Edit configuration Files" \
	        "INST"  "Installs/Updates a Service from Source" \
	        "BACK"  "Backup json & ini files to a single .cimg file" \
	        "R_UPDATE" "Updates the system" \
	        "EXIT"  "Exits this Program" 2> $tempfile

	retval=$?

	choice=`cat $tempfile`

	case $retval in
	  0)
		iv_proc_choice $choice;;
	  1)
	    echo "Cancel pressed.";;
	  255)
	    echo "ESC pressed.";;
	esac
}
iv_mainMenu;