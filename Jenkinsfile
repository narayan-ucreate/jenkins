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
        ACCESS_TOKEN= credentials('JENKINS_ACCESS_TOKEN')

    }
    stages {
        stage('install database') {
             steps {
                 updateGithubStatus('pending')
                 sh 'docker-compose -f docker-compose.yml up -d pgsql'
                 sh 'docker-compose -f docker-compose.yml up -d pgadmin'
             }
        }
        stage('Unit Testing') {
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
             updateGithubStatus('success')
        }
        failure {
             updateGithubStatus('failure')
        }
    }
}

void updateGithubStatus(status) {
     sh 'curl https://api.github.com/repos/narayan-ucreate/jenkins/statuses/'+env.git_COMMIT+'?access_token='+env.ACCESS_TOKEN+' --header "Content-Type: application/json" --data "{\\"state\\": \\"'+status+'\\", \\"description\\": \\"Jenkins\\"}"'
}
