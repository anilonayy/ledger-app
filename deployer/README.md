# How to deploy this api on AWS EC2?

## Step 1: Create an EC2 instance
Just visit the AWS Console site and launch a new instance with default configurations. [Ubuntu Server]
While you are launching the instance you need the create a new Key Pair for ssh login. 

Then you need the create an Elastic Ip and associate it with the instance. This will give you a static IP address for the instance.
## Step 2: Connect to the instance
After launching the instance you will get a public IP address. Use this IP address to connect to the instance using SSH.
```bash
ssh -i "your-key.pem" ubuntu@your-public-ip
```

## Step 3: Configuration the instance
Update the package list and install the required packages.

```bash
sudo apt update -y
sudo apt install docker -y
sudo apt install docker.io -y
sudo usermod -aG docker ubuntu
sudo curl -L "https://github.com/docker/compose/releases/download/v2.24.6/docker-compose-Linux-x86_64" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo service docker start
sudo apt install git -y
sudo apt install gh -y
sudo apt install python3 -y
sudo apt install python3-pip -y
```

### Step 4: Build the project
```bash
sudo git clone https://github.com/anilonayy/ledger-app.git
cd ./ledger-app/deployer
sudo chmod +x ./deployer.sh
./deployer.sh magic
```
Hmmm but still i can't see my project in the browser.

And after these steps you still may need to configure the security group of the instance to allow the incoming traffic on the port 80 and 443.

And ta daaaa! You have deployed the project on AWS EC2.
![img.png](img.png)


## Don't exicted yet! We still have not SSL Certificate...



I'm took reference from [this](https://www.youtube.com/watch?v=yhiuV6cqkNs&ab_channel=Scale-UpSaaS) video while preparing this file.
