echo "$(date '+%Y-%m-%d %H:%M:%S') $(top -c -b -n 5 | grep si.war | awk '{print $5,$6,$7,$9,$10}')" > HsaSiProcessesTopStatsData
mysql -u monitoring -pHitachi1 --local-infile -D charts -e "LOAD DATA LOCAL INFILE 'HsaSiProcessesTopStatsData' into table Si_Top_Stats FIELDS TERMINATED BY ' '";
mysql -u monitoring -pHitachi1 -D charts -e "select * from Si_Top_Stats";
rm -f HsaSiProcessesTopStatsData
cat HsaSiProcessesTopStatsData