<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ $invoice->name }}</title>
        <style>
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            h1,h2,h3,h4,h5,h6,p,span,div {
                font-family: DejaVu Sans;
                font-size:10px;
                font-weight: normal;
            }

            th,td {
                font-family: DejaVu Sans;
                font-size:10px;
            }

            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }

            .panel-default {
                border-color: #ddd;
            }

            .panel-body {
                padding: 15px;
            }

            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;

            }

            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }

            th, td  {
                border: 1px solid #ddd;
                padding: 6px;
            }

            .well {
                min-height: 20px;
                padding: 19px;
                margin-bottom: 20px;
                background-color: #f5f5f5;
                border: 1px solid #e3e3e3;
                border-radius: 4px;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            }
        </style>
    </head>
    <body>
        <header>
            <div style="position:absolute; left:0pt; width:250pt;">
                @php
                    $imagePath = public_path('/storage/' .$customer->logo);
                    if (file_exists($imagePath)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                    }
                @endphp
                @if(isset($imageData))
                    <img src="data:image/{{ $imageType }};base64,{{ $imageData }}" alt="Customer logo" style="max-width: 100px; max-height: 100px;" />
                    @else
                        <span>No Image Available</span>
                @endif
            </div>
            <div style="margin-left:300pt;">
                <b>Date: </b> {{ $invoice->created_at->format('d/m/Y') }}<br />
                @if ($invoice->created_at)
                    <b>Due date: </b>{{ $invoice->created_at->format('d/m/Y') }}<br />
                @endif
                @if ($invoice->number)
                    <b>Invoice #: </b> {{ $invoice->number }}
                @endif
                <br />
            </div>
            <br />
            <h2> {{ $invoice->number ? '#' . $invoice->number : '' }}</h2>
        </header>
        <main>
            <div style="clear:both; position:relative;">
                <div style="position:absolute; left:0pt; width:250pt;">
                    <h4>Customer Details:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! $customer->invoices()->count() == 0 ? '<i>No business details</i><br />' : '' !!}
                            ID: {{ $customer->number }}<br />
                            Company name: {{ $customer->company_name  }}<br />
                            Name: {{ $customer->name  }}<br />
                            Phone: {{ $customer->phone }}<br />
                            Address: {{ $customer->address }} {{ $customer->zip  }} {{ $customer->city  }}<br />
                        </div>
                    </div>
                </div>
                <div style="margin-left: 300pt;">
                    <h4>Work Details:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            ID: {{ $work->number }}<br />
                            Type: {{ $work->type  }}<br />
                            Category: {{ $work->category }}<br />
                            Work date: {{ $work->work_date  }}<br />
                            Time spent: {{ $work->time_spent }} h<br />
                        </div>
                    </div>
                </div>
            </div>
            <h4>Items:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($work->products as $item)
                        <tr>
                            <td>{{ $item->number }}</td>
                            <td>
                                @php
                                    $imagePath2 = public_path('/storage/' . $item->image);
                                    if (file_exists($imagePath2)) {
                                        $imageData2 = base64_encode(file_get_contents($imagePath2));
                                        $imageType2 = pathinfo($imagePath2, PATHINFO_EXTENSION);
                                    }
                                @endphp
                                @if(isset($imageData2))
                                    <img src="data:image/{{ $imageType2 }};base64,{{ $imageData2 }}" alt="Product Image" style="max-width: 100px; max-height: 100px;" />
                                @else
                                    <span>No Image Available</span>
                                @endif
                            </td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->pivot->quantity_used }}</td>
                            <td>{{ $item->price }} $</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="clear:both; position:relative;">
                <div style="margin-left: 300pt;">
                    <h4>Total:</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><b>Work cost</b></td>
                                <td>{{ $work->base_cost }}</td>
                            </tr>
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td><b>{{ $work->cost }} </b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Page count -->
        <script type="text/php">
            if (isset($pdf) && $GLOBALS['with_pagination'] && $PAGE_COUNT > 1) {
                $pageText = "{PAGE_NUM} of {PAGE_COUNT}";
                $pdf->page_text(($pdf->get_width()/2) - (strlen($pageText) / 2), $pdf->get_height()-20, $pageText, $fontMetrics->get_font("DejaVu Sans, Arial, Helvetica, sans-serif", "normal"), 7, array(0,0,0));
            }
        </script>
    </body>
</html>
