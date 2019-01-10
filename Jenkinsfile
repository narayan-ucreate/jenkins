pipeline {
    agent any
    environment {
        REDIS_HOST='localhost'
        DB_CONNECTION='pgsql'
        DB_HOST='postgres-test'
        DB_PORT='5432'
        DB_DATABASE='postgres'
        DB_USERNAME='postgres'
        DB_PASSWORD='postgres'

    }
    stages {
        stage('install php') {
            sh 'docker-compose -f docker-compose.yml up -d php-install'
        }
        stage('install database') {
            steps {
             sh 'docker-compose -f docker-compose.yml up -d postgres-test'
             sh 'docker-compose -f docker-compose.yml up -d pgadmin'
            }
        }
    }
}
