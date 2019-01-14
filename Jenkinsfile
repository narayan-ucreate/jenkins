pipeline {
    agent any
    environment {
        REDIS_HOST='localhost'
        DB_CONNECTION='pgsql'
        DB_HOST='ec2-13-233-43-203.ap-south-1.compute.amazonaws.com'
        DB_PORT='5434'
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
                        sh "php -r \"copy('.env.example', '.env');\""
                        sh 'php artisan key:generate'
                        sh 'composer install -n --prefer-dist'
                        sh './vendor/bin/phpunit'
                  }
        }

    }
    post {
                always {
                      sh('build.sh')
                }
                failure {
                   echo 'faild'
                }
    }
}
