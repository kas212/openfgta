#!/bin/sh
echo FGTA BACKUP UTILITY
echo ===================
echo
echo Backing Up FGTA Database
TARGET=/home/adminit/backup/fgta_$(date +%Y%m%d-%H%M).fbk
sudo gbak -v -b /var/database/FGTA.FDB $TARGET
sudo chown adminit.adminit $TARGET
echo
echo

echo Backing Up FGTARPT Database
TARGET=/home/adminit/backup/fgtarpt_$(date +%Y%m%d-%H%M).fbk
sudo gbak -v -b /var/database/FGTARPT.FDB $TARGET
sudo chown adminit.adminit $TARGET
echo
echo
echo Backing Up Database Completed.
echo
echo
