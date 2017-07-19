$("#uploadModal").resourceModule();

$(document).ready(function()
{
    $(".page-header").globalModule();
    $(".page-header").exampleModule();
    $(".attachModule").attachModule();
    $(".attachModule").previewModule();
    $("#monitorForm").monitorModule();
    $("#newMon").newMonitorModule();
    $("#resForm").resFormModule();
    $(".nav").feedbackModule();

    //separate in own js
    $("#monitorBody").deliverContentModule();

    console.log("Running.");
});