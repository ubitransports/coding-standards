#! /bin/bash

TARGET_BRANCH="master"
IMAGES_TO_BUILD="php-tools:ci"

buildImage() {
    local responseStatusCode=$(curl --request POST --form "variables[IMAGES_TO_BUILD]=$IMAGES_TO_BUILD" --form "token=$DOCKER_IMAGE_JOB_TOKEN" --form "ref=$TARGET_BRANCH"  --write-out '%{http_code}' --output /dev/null --silent "https://bitbox.plateforme-2cloud.com/api/v4/projects/81/trigger/pipeline")

    if ! echo $responseStatusCode | xargs | grep -q '^2'
    then
        echo "Error while triggering docker-images pipeline: $responseStatusCode"

        return 1
    fi
}

echo -e "\033[1mTrigger the related docker image build for $IMAGES_TO_BUILD on branch $TARGET_BRANCH\033[0m
Browse https://bitbox.plateforme-2cloud.com/ubitransport/docker-images/-/pipelines to see the build status."
buildImage
