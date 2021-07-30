#!/bin/bash
set -exuo pipefail

KUBE_NAMESPACE="beta-shop"
SPRYKER_PIPELINE="docker.staging"
STORES=(DE VN)
CLI_POD=$(kubectl -n ${KUBE_NAMESPACE} get pod --selector component=spryker-cli --field-selector=status.phase=Running -o name)

STORE="${STORES[0]}"
kubectl -n ${KUBE_NAMESPACE} exec "${CLI_POD}" -- bash -c "APPLICATION_STORE=${STORE} vendor/bin/install -r ${SPRYKER_PIPELINE} -s init-storage -s init-storages-per-region -s demodata"
