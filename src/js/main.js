$(document).ready(function()
{
    $(".page-header").globalModule();
    $(".page-header").exampleModule();
    $(".page-header").attachModule();
    $("#monitorForm").monitorModule();
    //$("#uploadModal").resourceModule();
    console.log("Running");
});