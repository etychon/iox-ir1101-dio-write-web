# Build the docker image
docker build -t iox-ir1101-dio-write-web .  &&

# Optionally you can run locally just to check if it works fine
# Obviously the Digital IO won't work...
#docker run --network host iox-ir1101-dio-write-web

# Build the IOx package based on the Docker image
ioxclient docker package iox-ir1101-dio-write-web . --use-targz --name iox-ir1101-dio-write-web
