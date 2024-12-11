<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['google_client_id'] = getenv('GOOGLE_CLIENT_ID');
$config['google_client_secret'] = getenv('GOOGLE_CLIENT_SECRET');
$config['google_redirect_uri'] = (ENVIRONMENT === 'development') 
    ? 'http://localhost/expiredSystem/login/google_auth' 
    : 'https://nadicom.my/expiredSystem/login/google_auth';

// Additional scopes can be added here if needed
$config['google_scopes'] = [
    'email',
    'profile',
];
