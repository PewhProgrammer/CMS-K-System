$("#uploadModal").resourceModule();

$(document).ready(function()
{
    $(".page-header").globalModule();
    $(".attachModule").attachModule().previewModule();
    $("#monitorForm").monitorModule();
    $("#newMon").newMonitorModule();
    $("#resForm").resFormModule();
    $(".nav").feedbackModule();

    //separate in own js
    $("#monitorBody").deliverContentModule();

    console.log("Running.");
});