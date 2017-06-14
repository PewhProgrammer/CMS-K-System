$(document).ready(function()
{
    console.log("Running");
    $(".page-header").exampleModule();
    $(".page-header").attachModule();
    $("#uploadModal").resourceModule();
});