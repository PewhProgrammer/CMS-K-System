$(document).ready(function()
{
    $(".page-header").exampleModule();
    $(".page-header").attachModule();
    $(".page-header").resourceModule();
    $("#monitorForm").monitorModule();
    $("#uploadModal").resourceModule();
    console.log("Running");
});