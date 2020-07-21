function redirectionToTest(element) {
  location.href = "./test.php?id=" + element.id;
}

function redirectionToReview(element) {
  location.href = "./review.php?id=" + element.id;
}

function successfulCallback(id) {
  window.open("./downloadXMLfile.php?id=" + id, "_blank");
}

function generateXMLfile(element) {
  let data = {
    testId: element.id,
  };

  var dataJSON = JSON.stringify(data);
  var dataRequest = {
    data: dataJSON,
    url: "./generateXMLfile.php",
    method: "POST",
    success: successfulCallback
  };

  ajax(dataRequest, element.id);
}

function ajax(dataRequest, id) {
  var xhr = new XMLHttpRequest();

  xhr.open(dataRequest.method, dataRequest.url, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      dataRequest.success(id);
    } else {
      console.log("Problems with response, try again.");
    }
  };

  xhr.send(dataRequest.data);
}

function addQuestionComment(element) {

  document.getElementById(element.id).disabled = true;

  let div_el = document.getElementById("div" + element.id);
  let p_el = document.createElement("p");
  p_el.setAttribute("class", "comment");

  let label1_el = document.createElement("label");
  label1_el.setAttribute("for", "inp" + element.id);
  let node = document.createTextNode("Input comment name: ");
  label1_el.appendChild(node);
  let inp1_el = document.createElement("input");
  inp1_el.setAttribute("type", "text");
  inp1_el.setAttribute("id", "inp" + element.id);
  inp1_el.setAttribute("name", "input");
  inp1_el.setAttribute("value", "");

  let br1 = document.createElement("br");
  let br2 = document.createElement("br");

  let label2_el = document.createElement("label");
  label2_el.setAttribute("for", "textArea" + element.id);
  node = document.createTextNode("Input comment: ");
  label2_el.appendChild(node);
  let textAr_el = document.createElement("textarea");
  textAr_el.setAttribute("cols", "21");
  textAr_el.setAttribute("class", "textArr");
  textAr_el.setAttribute("id", "area" + element.id);
  textAr_el.setAttribute("name", "area");

  var buttonCancel = document.createElement("button");
  buttonCancel.setAttribute("type", "button");
  buttonCancel.setAttribute("id", "butC"+element.id);
  buttonCancel.setAttribute("onclick", "addQuestionCommentSubmitCancel(this)");
  node = document.createTextNode("Cancel");
  buttonCancel.appendChild(node);

  var button = document.createElement("button");
  button.setAttribute("type", "button");
  button.setAttribute("id", "but"+element.id);
  button.setAttribute("onclick", "addQuestionCommentSubmit(this)");
  node = document.createTextNode("Submit");
  button.appendChild(node);

  p_el.appendChild(label1_el);
  p_el.appendChild(inp1_el);
  p_el.appendChild(br1);
  p_el.appendChild(label2_el);
  p_el.appendChild(textAr_el);
  p_el.appendChild(br2);
  p_el.appendChild(buttonCancel);
  p_el.appendChild(button);
  div_el.appendChild(p_el);
}

function addQuestionCommentSubmit(element) {
  let id = element.id.slice(3);
  let commentName = document.getElementById("inp" + id).value;
  let comment = document.getElementById("area" + id).value;

  let data = {
    questionId: id,
    commentName: commentName,
    comment: comment
  };

  var dataJSON = JSON.stringify(data);
  var dataRequest = {
    data: dataJSON,
    url: "./tests/testsReview-helper.php",
    method: "POST",
    success: moveCommentValuesToSubmitedDiv
  };

  ajax(dataRequest, id);
}

function addQuestionCommentSubmitCancel (element) {
  let id = element.id.slice(4);
  let div_el = document.getElementById("div" + id);
  div_el.innerHTML = "";
  document.getElementById(id).disabled = false;
}

function moveCommentValuesToSubmitedDiv(id) {

  let commentName = document.getElementById("inp" + id).value;
  let comment = document.getElementById("area" + id).value;

  let divSubmited = document.getElementById("divSubmited" + id);
  let p_el = document.createElement("p");
  p_el.setAttribute("class", "comment");

  let span1_el = document.createElement("span");
  let node = document.createTextNode("Comment name: " + commentName);
  span1_el.appendChild(node);

  let span2_el = document.createElement("span");
  node = document.createTextNode("Comment: " + comment);
  span2_el.appendChild(node);
  let br1 = document.createElement("br");

  p_el.appendChild(span1_el);
  p_el.appendChild(br1);
  p_el.appendChild(span2_el);
  divSubmited.appendChild(p_el);

  let div_el = document.getElementById("div" + id);
  div_el.innerHTML = "";

  document.getElementById(id).disabled = false;
}