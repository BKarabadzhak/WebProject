function redirectionToTest(element) {
  location.href = "./test.php?id=" + element.id;
}

function redirectionToReview(element) {
  location.href = "./review.php?id=" + element.id;
}


function generateXMLfile(element) {
  let data = {
    "testId": element.id,
  };

  var dataJSON = JSON.stringify(data);
  var dataRequest = {
    data: dataJSON,
    url: "./generateXMLfile.php",
    method: "POST",
  };

  ajax(dataRequest, element.id);
}


function ajax(dataRequest, id) {
  var xhr = new XMLHttpRequest();

  xhr.open(dataRequest.method, dataRequest.url, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      window.open("./downloadXMLfile.php?id=" + id, "_blank");
    } else {
      console.log("Problems with response, try again.");
    }
  };

  xhr.send(dataRequest.data);
}
