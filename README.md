# systemResourceMonitor
Monitoring for your system resources

Docker commands and it's usage

== Docker tips ==

1. What should i do when encountered error with docker pull command in local dev desktop.

Ans. Go to /etc/default/docker file check following settings and add following and try to run docker pull command.

# If you need Docker to use an HTTP proxy, it can also be specified here.
export http_proxy="http://guest.abc.com:8080/"


2. Use following command to build a new docker image from your local project directory 

      Ans.  docker build -t <docker-imange-name> .

      Note: Make sure you have your Dockerfile already in place in this folder before running above command

     What is Dockerfile?

        A Dockerfile is a file which has set of commands to be run in an order when container spins

   Ex:- 
     FROM docker/whalesay:latest (gets the latest code from whalesay project)
     RUN apt-get -y update && apt-get install -y fortunes (updates & installs fortunes program)
     CMD /usr/games/fortune -a | cowsay (executes fortune program )


3. Remove all stopped  containers:
 
    docker rm $(docker ps -a -q)

4. Remove all untagged  images:
 
   docker  images -q --filter "dangling=true" | xargs docker rm
   docker images -q --filter "dangling=true" | xargs docker rmi

   Note: Use ‘docker rmi -f‘ to force the removal of images even if there are some stopped containers based on them .

5. Remove all containers based on specific  image:
 
    docker ps --filter ancestor=codefresh/golang:1.1  -q | xargs -l docker stop

    docker ps --filter ancestor=testCode/golang:1.1 -q | xargs -l docker stop

        Note : You will need to replace testCode/golang:1.1 with your own <repository>:<tag> in the last command.
        
        If you omit the :<tag> –  ‘docker ps’ will return only the containers based on the ‘latest’ tag of the specified image. They are the ones that will get stopped.

6. Remove unused data volumes 
 
     docker volume rm $(docker volume ls -qf  dangling=true)

7. To run container logs running use following command

   docker logs -f <container_name>

8. To get info on processes running inside a container use following command

   docker top <container_name>

9. command to find a docker image from git hub

   docker search <software or os name>

   Ex:- if you want to get ubuntu image  use command 
    
        docker search ubuntu

10. One way to start containers in a way that two containers started on same host talk to each other via port with following command

    start first container with following command

          docker run --name docker_test1 -p 8011:8011 it <container_image_name Ex:- ubuntu>

    start second container with following command

          docker run --name docker_test2 --link docker_test1:docker_test1 -it <container_image_name Ex:- ubuntu> 

    Note: In above scenario communication between two containers happes via port 8011

    try ping with container names from both containers when running and verify

    ping docker_test1 from second container
    ping docker_test2 from first container


11. Command to list all available docker networks on host

    docker network ls

12. Command to create a user define docker bridge network

    docker network create --driver bridge <userdefine_network_name>

13. Command to know the details of any docker network

    docker network inspect <network name>

14. Command to add a container to user network or default network

    docker run --network=<docker network name> -itd --name=<userdefine container name> <container_image_name>

    Ex:- If you want to add ubuntu container to a user define network 

     docker run --network=none -itd --name=ubuntu_container1 ubuntu


15. To know details of docker container configuration go to following location and check

    cd /var/lib/docker/containers  - this folder will have all individual container id folders.

    Ex: - for docker container with id "5e8110c3951f" a folder with name "5e8110c3951f746dd7bde699db341370ff4b0afd9b728b29395d0023a4d11739" available in specified location


16. To start any os container and write data to it use following command.

    docker run -ti -v /data --name=test ubuntu bin/bash

    with above command we are starting a container with storage volume and adding a data directory to it. Now you can go to data directory and start writing data to it.

    After running above command do "cd _data" and start creating files with touch command

    ex:- touch 1 or touch abc or touch xxx

    run "Ctrl + P + Q" with will get you out of the container without killing the container process

    Once you return to OS console go to /var/lib/docker/volumes/<containerid>, you find the _data folder init. check the folder content. All files created within container available for user.

17. To attach user directory as data directory for a container use following command. Whatever data written in container will be stored in directory that you specified

    step1: $ mkdir user_data_directory
    step2: $ docker run -ti -v /user_data_directory:/data --name=userdata_ub1 ubuntu bin/bash
   
    once you are inside of container run following commands

    step3: cd /data
    step4: ls
    step5: touch 1
    step6: touch 2
    step7: touch 3
    ste[8: ls
    
    step9: ctrl + P + Q

    step:10: $ cd /user_data_directory
    ste[:11: $ls

    At step11 you will see files created in step 5,6,7

18. To start a container on a specific ip & port  and write data on it, use following command

    docker run -d -p 172.17.98.100:9901:9901 -ti -v /user_data_folder:/data --name=user_data_ub ubuntu bin/bash


19. Copying files from docker to local host/machine

    docker cp containerid:/filepath/filename filename

    Ex:- copying a start.sh file from container id 656ee432d99c

    docker cp 656ee432d99c:/start.sh start.sh


    Check start.sh file will be available in current folder from where you have executed above command


20. Command to connect to DB container

    docker exec -it <database_contanier_id> mysql -u <user_name> -p<password> <database_name>

21. Command to list network ip's of docker instances

    docker inspect  $(docker ps -q) | grep IPAddress

    docker inspect <container_id> | grep IPAddress

22. Command to insert data from a csv/text file into database table

    docker exec -it <container_id> mysql -uroot -D <database_name> -e "LOAD DATA INFILE '<csv_file_location' INTO TABLE <table_name>"

23. Command for running a select query outside of container

    docker exec -it <container_id> mysql -uroot -D <database_name> -e "select * from <table_name>"
    
    
    == nginx tips ==

1. To install nginx on your local OS dev box follow steps as mentioned in link

   "https://nginx.org/en/linux_packages.html"

2. nginx.config will be available in one of the locations after installation

    /usr/local/nginx/conf, /etc/nginx, or /usr/local/etc/nginx/.
    
    
    
    == Secure Copy Tips ==

Example syntax for Secure Copy (scp)

What is Secure Copy?

scp allows files to be copied to, from, or between different hosts. It uses ssh for data transfer and provides the same authentication and same level of security as ssh.

Examples

1. Copy the file "foobar.txt" from a remote host to the local host

      $ scp your_username@remotehost.com:foobar.txt /some/local/directory
      
2. Copy the file "foobar.txt" from the local host to a remote host

      $ scp foobar.txt your_username@remotehost.com:/some/remote/directory

3. Copy the directory "foo" from the local host to a remote host's directory "bar"

      $ scp -r foo your_username@remotehost.com:/some/remote/directory/bar

4. Copy the file "foobar.txt" from remote host "rh1.com" to remote host "rh2.com"

      $ scp your_username@rh1.com:/some/remote/directory/foobar.txt \
        your_username@rh2.com:/some/remote/directory/

5. Copying the files "foo.txt" and "bar.txt" from the local host to your home directory on the remote host

      $ scp foo.txt bar.txt your_username@remotehost.com:~

6. Copy the file "foobar.txt" from the local host to a remote host using port 2264

      $ scp -P 2264 foobar.txt your_username@remotehost.com:/some/remote/directory

7. Copy multiple files from the remote host to your current directory on the local host

   $ scp your_username@remotehost.com:/some/remote/directory/\{a,b,c\} .
   $ scp your_username@remotehost.com:~/\{foo.txt,bar.txt\} .

8. scp Performance

   A. By default scp uses the Triple-DES cipher to encrypt the data being sent. Using the Blowfish cipher has been shown to increase speed. This can be done by using option -c blowfish in the command line.

         $ scp -c blowfish some_file your_username@remotehost.com:~

   B. It is often suggested that the -C option for compression should also be used to increase speed. The effect of compression, however, will only significantly increase speed if your connection is very slow. Otherwise it may just be    adding   extra burden to the CPU. An example of using blowfish and compression:

         $ scp -c blowfish -C local_file your_username@remotehost.com:~


9. To generate RSA public & private keys use following command 
         
         $ssh-keygen -t rsa

    
    
