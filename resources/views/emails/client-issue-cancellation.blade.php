<!DOCTYPE html>
<html>
<head>
    <title>تأكيد إلغاء كشف حساب تم تصديره</title>
</head>
<body>
    <h3>
        <span><b>{{__('translation.name')}} :</b></span>
        <span>
            {{ $ClientStatementIsues->Client->fullname }}
        </span>
    </h3>

    <h3>
        <span><b>رمز العميل :</b></span>
        <span>
            GIZ-{{ $ClientStatementIsues->Client->id }}
        </span>
    </h3>

    <h3>
        <span><b>رقم الفاتورة :</b></span>
        <span>
            {{ $ClientStatementIsues->id }}
        </span>
    </h3>
    <h3>رمز التحقق الخاص بك هو  : </h3>
    <h3><b>{{ $otp }}</b></h3>
    <h3>انقر على الرابط أدناه لتأكيد إلغاء كشف الحساب:</h3>
    <h3><a href="{{ $link }}">تأكيد إلغاء الفاتورة رقم :   {{ $ClientStatementIsues->id }}</a></h3>
</body>
</html>
