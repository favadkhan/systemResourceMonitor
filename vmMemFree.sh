echo "$(date '+%Y-%m-%d %H:%M:%S') $(free -m | grep Mem: | sed 's/Mem://g')"|awk '{print $1,$2,$3,$4,$5,$6,$7,$8}' >> /tmp/memoryfree
mysql -u monitoring -D "charts" -e "LOAD DATA INFILE 'memoryfree' into table VM_stats FIELDS TERMINATED BY ' '";
mysql -u monitoring -pRequest1 -D "charts" -e "select * from VM_stats";
rm -rf /tmp/memoryfree
