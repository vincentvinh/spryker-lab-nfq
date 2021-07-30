#!/bin/bash
set -exuo pipefail

KUBE_NAMESPACE="beta-shop"
STORES=(DE AT)
CLI_POD=$(kubectl -n ${KUBE_NAMESPACE} get pod --selector component=spryker-cli --field-selector=status.phase=Running -o name)
DOCKER_IMAGE_VERSION="1.0"

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

for STORE in "${STORES[@]}"
do
    kubectl -n ${KUBE_NAMESPACE} exec "${CLI_POD}" -- bash -c "APPLICATION_STORE=${STORE} vendor/bin/console scheduler:suspend"
done

helm dependency update kubernetes/spryker
helm --namespace ${KUBE_NAMESPACE} upgrade --install spryker kubernetes/spryker \
    --set container.version="${DOCKER_IMAGE_VERSION}" \
    --wait
kubectl -n ${KUBE_NAMESPACE} rollout status -w deployment/cli
kubectl -n ${KUBE_NAMESPACE} rollout status -w deployment/scheduler
until [ $(kubectl -n ${KUBE_NAMESPACE} get pod --selector component=spryker-cli --field-selector=status.phase=Running -o name | wc -l) -eq 1 -a $(kubectl -n ${KUBE_NAMESPACE} get pod --selector component=spryker-scheduler --field-selector=status.phase=Running -o name | wc -l) -eq 1 ];
do
  echo "Waiting for the deployment ..."
  sleep 10s
done

sleep 30s
CLI_POD=$(kubectl -n ${KUBE_NAMESPACE} get pod --selector component=spryker-cli --field-selector=status.phase=Running -o name)
for STORE in "${STORES[@]}"
do
    kubectl -n ${KUBE_NAMESPACE} exec "${CLI_POD}" -- bash -c "APPLICATION_STORE=${STORE} vendor/bin/console scheduler:resume"
done

STORE="${STORES[0]}"
kubectl -n ${KUBE_NAMESPACE} exec "${CLI_POD}" -- bash -c "APPLICATION_STORE=${STORE} vendor/bin/console propel:install"
