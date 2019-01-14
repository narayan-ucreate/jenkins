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
        REPO_URL='narayan-ucreate/jenkins'
        ACCESS_TOKEN='029c49082b05041375aa993b0dc21eb696aaf71f'

    }
    stages {
        stage('install database') {
                steps {
                echo 'url'
                echo env.ACCESS_TOKEN
                    sh 'curl https://api.github.com/repos/narayan-ucreate/jenkins/statuses/'+env.git_COMMIT+'?access_token="029c49082b05041375aa993b0dc21eb696aaf71f" --header "Content-Type: application/json" --data "{\\"state\\": \\"pending\\", \\"description\\": \\"Jenkins\\"}"'
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
                success {
                   echo 'success'
                }
                failure {
                 echo 'faild'

                }
    }
}
