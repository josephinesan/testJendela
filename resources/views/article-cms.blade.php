<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Article CMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Article CMS</h1>
        <a href="/article/create" class="btn btn-primary">Add Article</a>

        <br>
        <br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-body">

            </tbody>
        </table>

        <div class="text-center" style="margin-bottom: 50px;">
            <p>Page positon: <span class="page-position">1</span></p>
            <button class="btn btn-primary previous" style="margin-right: 10px;"><</button>
            <button class="btn btn-primary next">></button>
        </div>
    </div>
      
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Article Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            
                <!-- Modal body -->
                <div class="modal-body">
                    <p>Article Name: <span class="article-name"></span></p>
                    <p>Article Name: <span class="article-slug"></span></p>
                    <p>Creator: <span class="article-creator"></span></p>

                    <a href="" class="article-href" target="_blank">See Page</a>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    const page = 0;
    const number_of_page = {{ $number_of_pages }};
    $(document).ready(function () {
        fetchArticle();
        checkPageButton();
    });
    
    /*
    * For fetching data 
    */
    function fetchArticle() {
        fetch('article/list?skip=' + page)
        .then(res => {
            res.json().then(data => {
                populateTable(data);
            });
        });
    }

    /*
    * For fetching article detail
    */
    function fetchArticleDetail() {
        fetch('article/detail?id=' + id)
        .then(res => {
            res.json().then(data => {
                $(".article-name").text(data);
                $(".article-slug").text(data);
                $(".article-creator").text(data);
                $(".article-href").attr('href', '/article/' + data);
            });
        });
    }

    /*
    * Populate data on table
    */
    function populateTable(data) {
        const table_data = data.map(data => {
            return '<tr><td>'+ data.name +'</td><td>'+ data.slug +'</td><td><button class="btn btn-primary btn-detail" data-id="'+ data.slug +'">Show Detail</button><button class="btn btn-danger btn-delete" data-id="'+ data.slug +'">Delete</button></td></tr>'
        });
        
        $(".table-body").append(table_data);
    }

    /*
    * Move to the previous Page
    */
    $(".previous").click(function() {
        page--;
        fetchArticle();
    });

    /*
    * Move to the next Page
    */
    $(".next").click(function() {
        page++;
        fetchArticle();
    });

    /*
    * Check Page Button
    */
    function checkPageButton() {
        if (page) {
            
        }
    }

    /*
    * Click to Show Detail of Article
    */
    $(".btn-detail").click(function () {
    fetchArticleDetail($(this).attr('data-id'));
        alert('show modal');
    });

    /*
    * Click to Delete Article
    */
    $(".btn-delete").click(function () {
        if (confirm('Anda yakin ingin menghapus?')) {
            fetch('article/' + $(this).attr('data-id'), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "",
                }
            }).then(response => {
                fetchArticle();
            })
        }
    });

</script>
</html>