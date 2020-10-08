<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('button.store').click(function() {
                var $btn = $(this);
                $btn.text('...');
                $.ajax({
                    'method' : 'GET',
                    'url' : '/product/store/' + $btn.data('product-id'),
                    'success' : function() {
                        $btn.text('SAVED');
                    },
                    'error' : function() {
                        $btn.text('error');
                    }
                })
            });
        });
    </script>
</head>
<body>
    <style>
        ul.pagination li {
            display:  inline;;
        }
    </style>
    @if($paginator->total())
    <table border="1">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Categories</th>
            <th>Save</th>
        </thead>
        @foreach ($paginator as $product)
            <tr>
                <td>{{$product->getId()}}</td>
                <td>{{$product->getName()}}</td>
                <td>@if($product->getImageUrl())
                        <img src="{{$product->getImageUrl()}}" height="100">
                    @else
                        -
                    @endif
                </td>
                <td>
                    <ul>
                    @foreach($product->getCategoriesArray() as $category)
                        <li>{{$category}}</li>
                    @endforeach
                    </ul>
                </td>
                <td>
                    <button class="store" data-product-id="{{$product->getId()}}"> Save </button>
                </td>
            </tr>
        @endforeach

    </table>
        {{$paginator->links('vendor/pagination/default')}}
    @else
    No entries
    @endif
</body>
</html>
