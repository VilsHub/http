<?php 
Request::post("/api/newsletter/{name}/{^[0-9a-zA-z]+$}", function($name, $id){
    $campaign = new Campaign();
    $campaign->subscribe(Request::data("clean")->fromPost("email"));
});
Request::post("/api/newsletter/{name}/{^[0-9a-zA-z]+$}", "Campaign@subscribe");
?>