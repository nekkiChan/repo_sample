<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form Example</title>
</head>
<body>

<form id="myForm" action="getTest.php" method="get">
    <input type="text" name="param1" value="value1">
    <input type="text" name="param2" value="">
    <input type="text" name="param3" value="value3">
    <!-- 空の値を持つパラメータを除外する -->
    <button type="button" onclick="submitForm(this)">Submit</button>
</form>

<script>
function submitForm(element) {
    var form = element.form;
    var inputs = form.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value === "") {
            inputs[i].removeAttribute("name");
        }
    }
    form.submit();
}
</script>

</body>
</html>
