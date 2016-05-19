<?php
$jsonFile=dirname(__FILE__)."/countries.json";
$json=file_get_contents($jsonFile) or die("NO");
$countriesArray=json_decode($json,TRUE);

return [
    'adminEmail' => 'admin@example.com',
    'application_name'=>'RAPIDIFY APP',
	'base_api'=>'http://api.rapidassign.com/v3',
    'forgot_password_api'=>'http://api.rapidassign.com/v3/account/passwordrequest',
    'register_api'=>'http://api.rapidassign.com/v3/account',
    'login_api'=>'http://api.rapidassign.com/v3/account/loginemail',
	'google_login_api'=>'http://api.rapidassign.com/v3/accountmanager/accounts/logingplus',
	'avatar_upload_api'=>'http://api.rapidassign.com/v3/account/{rapiduserid}/avatarupload',
	'fb_login_api'=>'http://api.rapidassign.com/v3/accountmanager/accounts/loginfacebook',
    'logout_api'=>"http://api.rapidfy.com/v3/accountmanager/v1/accounts/{rapiduserid}/logout",    
	'reply_api'=>"http://api.rapidassign.com/v1/administration/requestdetail?ref={ref}&sref={sref}",  
	'quote_api'=>"http://api.rapidassign.com/v1/webrequests/quotes",
	'job_respond_api'=>"http://api.rapidassign.com/v1/webrequests/{jobId}/respond",      
	'all_requests_api'=>"http://api.rapidassign.com/v3/users/{rapiduserid}/requests",	
	'requestinbox_api'=>"http://api.rapidassign.com/v3/users/{rapiduserid}/requestinbox?page={page}",
	'all_tasks_api'=>"http://api.rapidassign.com/v3/users/{rapiduserid}/tasks",
	'request_details'=>"http://api.rapidassign.com/v3/users/{rapiduserid}/requests/{req_id}",
	'responder_details_api'=>"http://api.rapidassign.com/v3/users/{rapiduserid}/requests/{req_id}/responses/{responses_id}",
	'respond_conversations'=>"http://api.rapidassign.com/v3/users/{rapiduserid}/requests/{req_id}/responses/{responses_id}/messages",
	'countriesArray'=>$countriesArray
];