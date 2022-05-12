<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Admin Panel</title>
</head>

<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>ELECTRICTY-PROTECT</h1>
        </div>
        <ul>
            <li><img src="img/dashboard (2).png"  alt="">&nbsp; <span>Dashboard</span> </li>
            <li><img src="img/reading-book (1).png" alt="">&nbsp;<span>Problem Meters</span> </li>
            <li><img src="img/teacher2.png" alt="">&nbsp;<span>Utility Staff</span> </li>
            <li><img src="img/school.png" alt="">&nbsp;<span>Statistics</span> </li>
            <li><img src="img/help-web-button.png" alt="">&nbsp; <span>Help</span></li>
            <li><img src="img/settings.png" alt="">&nbsp;<span>Settings</span> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="img/search.png" alt=""></button>
                </div>
                <div class="user">
                    <a href="#" class="btn">Add New</a>
                    <img src="img/notifications.png" alt="">
                    <div class="img-case">
                        <img src="img/user.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1>0</h1>
                        <h3>Meters installed</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/meter1.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>0</h1>
                        <h3>Meters in operation</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/meter.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>0</h1>
                        <h3>Potential theft detected</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/warning.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>0%</h1>
                        <h3>Percentage of meters detecting theft</h3>
                    </div>
                    <div class="icon-case">
                        <img src="img/percent.png" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Electricty Theft Detection by month</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <div id="wrapper">
                        <div id="myPlot" style="width:100%;max-width:700px">
                            <script>
                            var xArray = ["January","February","March","April","May","June","July","August","September","October","November","December"];
                            var yArray = [550, 490, 440, 724, 315,291,124,167,109,115,607,954];
                            
                            var data = [{
                              x: xArray,
                              y: yArray,
                              type: "bar"  }];
                            var layout = {title:"2022"};
                            
                            Plotly.newPlot("myPlot", data, layout);
                            </script>
                        </div>
                     </div>
                    </div>
                <div class="new-students">
                    <div class="title">
                        <h2>Pending Inspections</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            <th>Meter No.</th>
                            <th>Digital address</th>
                            <th>option</th>
                        </tr>
                        <tr>
                            <td>MNILM1</td>
                            <td>DX-10331</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>MNILM5</td>
                            <td>DX-13942</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>MNILM18</td>
                            <td>DX-19302</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>MNILM13</td>
                            <td>DX-10391</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>