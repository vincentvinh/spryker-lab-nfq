#!/bin/bash
set -exuo pipefail

APP_IMAGE_NAME_NAMESPACE=beta-shop
BUILT_DOCKER_IMAGE_VERSION=1.0
DOCKER_IMAGE_VERSION=$BUILT_DOCKER_IMAGE_VERSION
INTERNAL_CONTAINER_REGISTRY=registry.k8s.spryker-solution.nfq.internal

while getopts "t:" opt; do
    case "${opt}" in
        t)
            DOCKER_IMAGE_VERSION=${OPTARG}
            ;;
        # Unknown option specified
        \?)
            printf "\nUnknown option -%s is acquired.\n" ${OPTARG}
            exit 1
            ;;
        *)
            echo ${opt}
            ;;
    esac
done

for IMAGE_SUFFIX in app frontend cli
do
    DOCKER_IMAGE=${APP_IMAGE_NAME_NAMESPACE}_${IMAGE_SUFFIX}
    docker image tag ${DOCKER_IMAGE}:${BUILT_DOCKER_IMAGE_VERSION} ${INTERNAL_CONTAINER_REGISTRY}/${DOCKER_IMAGE}:${DOCKER_IMAGE_VERSION}
    docker image push --all-tags ${INTERNAL_CONTAINER_REGISTRY}/${DOCKER_IMAGE}
done
