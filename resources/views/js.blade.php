<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js//popper.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script>
    function getISODATE(date = undefined) {
        let d;
        if (date == undefined) {
            d = new Date();
        }else{
            d = new Date(date);
        }
        date = d.getDate() < 10 ? '0'+d.getDate() : d.getDate();
        month = d.getMonth()<9?('0'+(d.getMonth()+1)):(d.getMonth()+1);
        ISODate = d.getFullYear()+'-'+month+'-'+date;
        return ISODate
    }
</script>
