$(document).ready(function () {
  $.getJSON("survey.json", function (surveyJSON) {
    let pageTimes = {};

    const survey = new Survey.Model(surveyJSON);

    survey.onCurrentPageChanged.add(function (sender, options) {
      const currentPage = options.oldCurrentPage
        ? options.oldCurrentPage.name
        : null;
      const endTime = new Date().getTime();

      if (currentPage) {
        if (!pageTimes[currentPage]) {
          pageTimes[currentPage] = {
            startTime: null,
            endTime: null,
            duration: 0,
          };
        }
        pageTimes[currentPage].endTime = endTime;
        pageTimes[currentPage].duration =
          (endTime - pageTimes[currentPage].startTime) / 1000; // Convertir a segundos
      }

      const nextPage = options.newCurrentPage.name;
      if (!pageTimes[nextPage]) {
        pageTimes[nextPage] = {
          startTime: new Date().getTime(),
          endTime: null,
          duration: 0,
        };
      }

      // Renderizar la imagen manualmente
      if (nextPage === "page3") {
        $("#surveyContainer img.survey-image").css({
          "max-width": "100%",
          height: "auto",
          display: "block",
          margin: "0 auto",
        });
      }
    });

    survey.onComplete.add(function (sender) {
      const results = sender.data;
      results.pageTimes = pageTimes;

      $.ajax({
        url: "saveSurvey.php",
        type: "POST",
        data: JSON.stringify(results),
        contentType: "application/json; charset=utf-8",
        success: function (response) {
          alert("Encuesta enviada con éxito");
        },
        error: function (error) {
          alert("Error al enviar la encuesta");
        },
      });
    });

    $("#surveyContainer").Survey({ model: survey });
  }).fail(function () {
    alert("Error al cargar el archivo survey.json");
  });
});
