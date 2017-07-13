$("#uploadModal").resourceModule();

$(document).ready(function()
{
    $(".page-header").globalModule();
    $(".page-header").exampleModule();
    $(".attachModule").attachModule();
    $(".attachModule").previewModule();
    $("#monitorForm").monitorModule();
    $("#resForm").resFormModule();
    $(".nav").feedbackModule();

    //separate in own js
    $("#monitorBody").deliverContentModule();
    $("#monitorBody").CalDAVModule();



    console.log("Running");
});