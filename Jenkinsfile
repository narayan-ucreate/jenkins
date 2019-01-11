pipeline {
    agent any
    environment {
        REDIS_HOST='localhost'
        DB_CONNECTION='pgsql'
        DB_HOST='pgsql'
        DB_PORT='5432'
        DB_DATABASE='test'
        DB_USERNAME='postgres'
        DB_PASSWORD='postgres'

    }
    stages {
        stage('install database') {
                steps {
                 sh 'docker-compose -f docker-compose.yml up -d pgsql'
                 sh 'docker-compose -f docker-compose.yml up -d pgadmin'

                }
        }
        stage('install php') {
                    agent {
                        docker { image 'ucreateit/php7.2:v0.1' }
                    }

                 steps {
                      sh 'php --version'
                        sh 'php -m'
                        sh "php -r \"copy('.env.example', '.env');\""
                        sh 'php artisan key:generate'
                        sh 'composer install -n --prefer-dist'
                        sh './vendor/bin/phpunit'

                  }
        }

    }
}
