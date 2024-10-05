 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Registration Mail</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>
  <h1>Welcome {{ $mailData['name'] }}</h1>
  <p>مرحبا بك عملنا العزيز في شركتنا،
 حيث يمكن لحضرتك طلب لي خدمة تريدها، 
 ونعدك أن نعمل على قدم وساق 
 من أجل تقديم المستوى المطلوب من الخدمات.
:</p>
  <p>
   your Email: {{ $mailData['email'] }}
    <br>
    your Phone: {{ $mailData['phone'] }}</p>
  <br>
  
  

  

</body>
</html>