#!/bin/sh
gitcmd='/opt/gitlab/embedded/bin/git'
$gitcmd log -1 | grep -q -e ^Merge
if [ $? -ne 0 ]; then
   exit 0
fi
VERSION_INFO=`$gitcmd log -1 | grep -e ^Merge`


versionOne=`echo $VERSION_INFO |  awk '{print $2}'`
versionTwo=`echo $VERSION_INFO |  awk '{print $3}'`
$gitcmd diff $versionOne  $versionTwo --name-only -z | xargs -0 -n 1 sh -c '
    for FILE; do
        file --brief "$FILE" | grep -q PHP
        if [ $? -eq 0 ]; then
			/opt/php7/bin/php -l  $FILE | grep -q "No syntax errors"
       	    if [ $? -ne 0 ]; then
                error=`/opt/php7/bin/php -l  $FILE` 
                echo $error
				var_err=1
            fi
	
        fi
    done
    if [[ $var_err -eq 1 ]]; then
		exit 1
    fi
' sh
