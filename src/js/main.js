$("#uploadModal").resourceModule();

$(document).ready(function()
{
    $(".page-header").globalModule();
    $(".page-header").exampleModule();
    $(".attachModule").attachModule();
    $("#monitorForm").monitorModule();
    $("#resForm").resFormModule();
    $(".nav").feedbackModule();

    console.log("Running");
});