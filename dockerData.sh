docker stats --no-stream $(docker ps | awk '{if(NR>1) print $NF}')|sed -E "s/\// /g"|sed -E "s/\%/ /g"|awk '{print $1,$2,$7}'|awk 'NR>1' >> docker_stats_outputdata
mysql -u monitoring -pRequest1 --local-infile -D charts -e "LOAD DATA LOCAL INFILE 'docker_stats_outputdata' into table docker_stats_data FIELDS TERMINATED BY ' '"
mysql -u monitoring -pRequest1 -D charts -e "select * from docker_stats_data"
