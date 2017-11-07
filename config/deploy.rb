# config valid for current version and patch releases of Capistrano
lock "~> 3.10.0"

set :application, "foot5x5"

set :repo_url, "git@github.com:etistav/foot5x5.git"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# SSH ACCESS REMINDER
# ssh footxfrsil@ssh.cluster011.ovh.net

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/home/footxfrsil"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml", "config/secrets.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"
# append :linked_dirs, "web/uploads"

set :tmp_dir, "/home/footxfrsil/tmp"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
set :keep_releases, 3

# Uncomment the following to require manually verifying the host key before first deploy.
# set :ssh_options, verify_host_key: :secure
set :ssh_options, { :forward_agent => true }

#
# Symfony defaults
#
set :symfony_env, "prod"

# Valeurs pour SF2. Pour SF3 mettre 3 et 5
set :symfony_directory_structure, 2
set :sensio_distribution_version, 4

# symfony-standard edition top-level directories : Pour SF2
set :app_path, "app"
set :web_path, "web"
set :var_path, "var"
set :bin_path, "bin"

# Use closures for directories nested under the top level dirs, so that
# any changes to web/app etc do not require these to be changed also
set :app_config_path, -> { fetch(:app_path) + "/config" }
set :log_path, -> { fetch(:symfony_directory_structure) == 2 ? fetch(:app_path) + "/logs" : fetch(:var_path) + "/logs" }
set :cache_path, -> { fetch(:symfony_directory_structure) == 2 ? fetch(:app_path) + "/cache" : fetch(:var_path) + "/cache" }
set :upload_path, -> { fetch(:web_path) + "/uploads" }

# console
set :symfony_console_path, -> { fetch(:symfony_directory_structure) == 2 ? fetch(:app_path) + '/console' : fetch(:bin_path) + "/console" }
set :symfony_console_flags, "--no-debug"
set :controllers_to_clear, ["app_*.php"]
# assets
set :assets_install_path, fetch(:web_path)
set :assets_install_flags, '--symlink'
#
# Capistrano shared dossiers et fichiers
#
set :linked_files, %w{app/config/parameters.yml}
set :linked_dirs, -> { [fetch(:log_path), fetch(:upload_path)] }
#
# Configure capistrano/file-permissions defaults
#
set :file_permissions_paths, -> { fetch(:symfony_directory_structure) == 2 ? [fetch(:log_path), fetch(:cache_path)] : [fetch(:var_path)] }
# Method used to set permissions (:chmod, :acl, or :chown)
set :permission_method, false

set :composer_install_flags, '--prefer-dist --no-interaction --quiet --optimize-autoloader'



after 'deploy:updated', 'symfony:assets:install'