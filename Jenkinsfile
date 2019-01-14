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
        ACCESS_TOKEN='c8e79908bd907d3ff449760e805ae1fe717d1929'

    }
    stages {
        stage('install database') {
                steps {
                echo 'url'
                echo env.REPO_URL
                    sh 'curl https://api.github.com/repos/narayan-ucreate/jenkins/statuses/682e130247dc61ea721c5f2049eb18faed2ec726?access_token='+env.ACCESS_TOKEN+' --header "Content-Type: application/json" --data "{\\"state\\": \\"pending\\", \\"description\\": \\"Jenkins\\"}"'
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
                    sh 'curl https://api.github.com/repos/' + env.REPO_URL + '/statuses/'+ env.GIT_COMMIT+'?access_token='+env.ACCESS_TOKEN+' --header "Content-Type: application/json" --data "{\\"state\\": \\"success\\", \\"description\\": \\"Jenkins\\"}"'
                }
                failure {
                   sh 'curl https://api.github.com/repos/'+env.REPO_URL+'/statuses/'+ env.GIT_COMMIT+'?access_token='+env.ACCESS_TOKEN+' --header "Content-Type: application/json" --data "{\\"state\\": \\"failure\\", \\"description\\": \\"Jenkins\\"}"'
                }
    }
}
