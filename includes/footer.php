    
        <div id="footer" class="p-3 bg-primary text-white fixed-bottom">
            <p class="text-center">Copyright &copy; - IT Conference Attendance System <?php echo date('Y'); ?></p>

        </div>

    </div>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Note that the above is for bootstrap to work. We are using a newer jquery version. But below we also have to include the older jquery version to use the jquery-ui widget datepicker() -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Note that the below is an older jquery version, which we are needing to include in order for the jquery-ui file to work with the datepicker() function. -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#dob" ).datepicker( {
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat: "yy-mm-dd"
            });
        } );
    </script>
  </body>
</html>
<!-- The element #dob is the one that the jquery datepicker function will be used on. -->

<!-- https://jqueryui.com/datepicker/ is where we got the datepicker code from. We made sure the required links were included in the correct order to use it. -- The function is in the footer file. We did have a link for it in the heater file too. -->