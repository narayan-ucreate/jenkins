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

    }
    stages {
        stage('install database') {
                steps {
                    sh 'curl https://api.github.com/repos/' + REPO_URL + '/statuses/'+ env.GIT_COMMIT+'?access_token="d843bb6d8711c6355dfdb1202aa9a45ca2007ee5" --header "Content-Type: application/json" --data "{\\"state\\": \\"pending\\", \\"description\\": \\"Jenkins\\"}"'
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
                    sh 'curl https://api.github.com/repos/' + REPO_URL + '/statuses/'+ env.GIT_COMMIT+'?access_token="d843bb6d8711c6355dfdb1202aa9a45ca2007ee5" --header "Content-Type: application/json" --data "{\\"state\\": \\"success\\", \\"description\\": \\"Jenkins\\"}"'

                }
                failure {
                   sh 'curl https://api.github.com/repos/' + REPO_URL + '/statuses/'+ env.GIT_COMMIT+'?access_token="d843bb6d8711c6355dfdb1202aa9a45ca2007ee5" --header "Content-Type: application/json" --data "{\\"state\\": \\"failure\\", \\"description\\": \\"Jenkins\\"}"'
                }
    }
}
