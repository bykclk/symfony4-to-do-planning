# To-Do Planning Demo project

## How to run?

The project includes Docker environment and a Makefile for docker shortcuts. Start docker containers with `make start` and then you can run `make install` for initial installation. 

## How to run demo mode?

Run `make start` and then `make install-demo` commands. You can go to `http://localhost` now.

## Make shortcuts

You can run all commands with `make command-name` command.

- `start` starts the docker containers.
- `stop` stops the docker containers.
- `rebuild-php` rebuilds the Dockerfile for php container.
- `restart` stops then starts the containers.
- `install` installs the application for development.
- `install-demo` install the application with demo fixtures. 
- `reinstall` removes database and reinstall the project with backend and frontend dependencies.
- `install-backend` runs composer install inside the php container.
- `install-demo-data` runs fixture loading command inside php container.
- `reset-database` remove whole database and recreates.
- `database-initials` runs database migrations inside php container.
- `install-frontend` runs yarn install and yarn build commands inside node container.
- `ui-dev` runs encore dev --watch command inside container.
- `web-shell` runs php container
- `node-shell` runs node container
- `logs` prints out logs from php container
- `data-reset` runs `reset-database` and `database-initials` commands.
- `pull` fetch last commits from git remote for active branch.
- `update` runs `pull` and `reinstall` commands.