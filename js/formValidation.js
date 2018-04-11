 $(document).ready(function () {   
  listAllCompanies();
  listAllUsers();
         $("#addUserButton").click(function() {  /* Add new user */
          var form = $("#addUserForm");
          var username = $("#username").val();
          if (username == '') { 
            alert("Please enter user name");
            $("#username").focus();
            return false;
          }      

         var url = "process/actionPage.php"; 
         $.ajax({
           type: "POST",
           url: url,
           data: $("#addUserForm").serialize(), 
           success: function(data)
           {
               alert('User added successfully'); 
               window.location.reload();                
                  }
                });
});


         $("#addCompanyButton").click(function() {   /* Add new company */
          var form = $("#addCompanyForm");
          var companyname = $("#companyname").val();

          if (companyname == '') { 
            alert("Please enter Company name");
            $("#companyname").focus();
            return false;
          }      

         var url = "process/actionPage.php"; 
         $.ajax({
           type: "POST",
           url: url,
           data: $("#addCompanyForm").serialize(), 
           success: function(data)
           {
            alert('Company has been added successfully'); 
            window.location.reload();
          }
        });
});


         function listAllCompanies()       /* List all comapny list */
         {
          var url = "process/actionPage.php"; 
          var form_type="companyList";
          $.ajax({
           type: "POST",
           url: url,     
           data:{formType:form_type},  
           success: function(data)
           {    
              $("#companyList").html(data);
              $("#companyList2").html(data);
              $("#companyList3").html(data);
            }
          });
        }


        $('#addCompanyForm').on('change', 'select', function (e) {  /* Get users list associated to the company */
          var id = $(e.target).val();
          var form_type="usersList";
          var url = "process/actionPage.php"; 
          $.ajax({
           type: "POST",
           url: url,   
           data:{company_id:id,formType:form_type},  
           success: function(data)
           {        
             $("#usersList").html(data);

           }
         });
        });

        $(document).on("click","a", function (e) {   /* Delete user from the company */
          var userId=$(this).attr("data-id"); 
          var form_type="deleteUser";
          var url = "process/actionPage.php";

   if(userId!=undefined){
    var r = confirm("Are you sure want to remove this user from company?");
    if (r == true) {

     $.ajax({
       type: "POST",
       url: url,     
       data:{user_id:userId,formType:form_type},
       success: function(data)
       {             
               if(data!=''){             
                     alert('User has been removed from the company!');
                     window.location.reload();
                   }     

             }
           });

   }
  }

  });


        function listAllUsers()  /* List all users in select drop list */
        {
          var form_type="listUsers";
          var url = "process/actionPage.php";
          $.ajax({
           type: "POST",
           url: url,  
           data:{formType:form_type},    
           success: function(data)
           {
            $("#usersList1").html(data);
          }
        });
        }


        $("#addUserToCompanyButton").click(function() {  /* Add users to company */
          var form = $("#addUserToCompany");
          var comapny = $("#comapny").val();
          var user_val = $("#users").val();
          if (user_val == '') { 
            alert("Please select the user");
            $("#users").focus();
            return false;
          } 

          if (comapny == '') { 
            alert("Please select Company name");
            $("#comapny").focus();
            return false;
          }     
           var url = "process/actionPage.php"; 

           $.ajax({
             type: "POST",
             url: url,
             data: $("#addUserToCompany").serialize(), 
             success: function(data)
             {                
                if(data!=''){
                  alert('User has been added to the company'); 
                  window.location.reload();
                }
              }
            });

         });

      });