# Spryker B2C Demo Shop

## Docker installation

For detailed installation instructions of Spryker in Docker, see [Getting Started with Docker](https://documentation.spryker.com/docs/getting-started-with-docker).

For troubleshooting of Docker based instanaces, see [Troubleshooting](https://documentation.spryker.com/docs/spryker-in-docker-troubleshooting).

### Prerequisites

For the installation prerequisites, see [Docker Installation Prerequisites](https://documentation.spryker.com/docs/docker-installation-prerequisites).

Recommended system requirements for MacOS:

|Macbook type|vCPU| RAM|
|---|---|---|
|15' | 4 | 16GB |
|13' | 4 | 16GB |

### Installation

Clone the repoitory along with the sub-modules
```shell
git clone git@github.com:nfq-asia/spryker-beta-shop.git --recurse-submodules
```

### Developer environment

1. Run the commands right after cloning the repository:

```bash
docker/sdk boot deploy.dev.yml
```

> Please, follow the recommendations in output in order to prepare the environment.

```bash
docker/sdk up
```

2. Git checkout:

```bash
git checkout your_branch
docker/sdk boot -s deploy.dev.yml
docker/sdk up --build --assets --data
```

> Optional `up` command arguments:
>
> - `--build` - update composer, generate transfer objects, etc.
> - `--assets` - build assets
> - `--data` - get new demo data

3. If you get unexpected application behavior or unexpected errors:

    1. Run the command:
    ```bash
    git status
    ```

    2. If there are unnecessary untracked files (red ones), remove them.

    3. Restart file sync and re-build the codebase:
    ```bash
    docker/sdk trouble
    docker/sdk boot -s deploy.dev.yml
    docker/sdk up --build --assets
    ```

4. If you do not see the expected demo data on the Storefront:

    1. Check the queue broker and wait until all queues are empty.

    2. If the queue is empty but the issue persists, reload the demo data:
    ```bash
    docker/sdk trouble
    docker/sdk boot -s deploy.dev.yml
    docker/sdk up --build --assets --data
    ```

### Troubleshooting

**No data on Storefront**

Use the following services to check the status of queues and jobs:
- queue.spryker.local
- scheduler.spryker.local

**Fail whale**

1. Run the command:
```bash
docker/sdk logs
```
2. Add several returns to mark the line you started from.
3. Open the page with the error.
4. Check the logs.

**MacOS and Windows - files synchronization issues in Development mode**

1. Follow sync logs:
```bash
docker/sdk sync logs
```
2. Hard reset:
```bash
docker/sdk trouble && rm -rf vendor && rm -rf src/Generated && docker/sdk sync && docker/sdk up
```

**Errors**

`ERROR: remove spryker_logs: volume is in use - [{container_hash}]`

1. Run the command:
```bash
docker rm -f {container_hash}
```
2. Repeat the failed command.

`Error response from daemon: OCI runtime create failed: .... \\\"no such file or directory\\\"\"": unknown.`

Repeat the failed command.

### Deployment

This is the deployment process to Kubernetes. We must prepare:

* The `beta-shop` namespace in K8s
* A `reader` service account with appropriate RBAC settings for rabbitmq chart

Both CI and deployments are executed in GitHub workflows.

#### Deployment workflow

The deployment is NOT run when `master` is updated nor a tag is created. The deployment workflow is
run automatically when a new [**release**](https://github.com/nfq-asia/spryker-beta-shop/releases) is created in GitHub.

* Create a new release, wait for the workflow to be finished
* The migration is run within the deployment workflow
* If more console or commands need running, use the manual [*Run on Spryker CLI*](https://github.com/nfq-asia/spryker-beta-shop/actions/workflows/spryker_cli.yml)
  workflow with the command to be run and the store name.

#### Release naming convention

Release should follow semver (`MAJOR.MINOR.PATCH`) for naming convention with the `v` prefix.
Tags and releases must share the same name. In the development, we only increase
minor and patch number:

* Increase the minor number for stories.
* Increase the patch number for bug fixes.

#### Staging endpoints:

Yves:
* https://www.de.beta-shop.dev.spryker.nfq.asia
* https://www.vn.beta-shop.dev.spryker.nfq.asia

Zed:
* https://os.vn.beta-shop.dev.spryker.nfq.asia
* https://os.de.beta-shop.dev.spryker.nfq.asia

Dev tools:
* https://redis-commander.beta-shop.dev.spryker.nfq.asia
* https://pgadmin.beta-shop.dev.spryker.nfq.asia
* https://scheduler.beta-shop.dev.spryker.nfq.asia
* https://broker.beta-shop.dev.spryker.nfq.asia
* https://kibana.beta-shop.dev.spryker.nfq.asi
