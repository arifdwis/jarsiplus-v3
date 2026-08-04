<style type="text/css">
.chart-statistic-box {
    margin-bottom: 15px!important;
}
.statistic-box {
    margin-bottom: 20px!important;
}
body {
    /*background: url(https://cdn.enterwind.com/assets/smr-dprd/img/bg.svg) no-repeat center center fixed!important; */
  {{-- background: url({{asset('img/bg.svg')}}) no-repeat center center fixed!important;  --}}
  /*background: #fffefb;*/
  -webkit-background-size: cover!important;
  -moz-background-size: cover!important;
  -o-background-size: cover!important;
  background-size: cover!important;
}
#analytics-dashboard {
    display: none;
}
.Dashboard--full {
    max-width: 100%;
}
.Dashboard {
    border: 0px solid #d4d2d0;
    background: #fff;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
}
.Dashboard-header {
    border-bottom: 0px solid #d4d2d0;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.Dashboard-footer, .Dashboard-header {
    margin: -1.5em -1.5em 1.5em;
    padding: 1.5em;
}
.FlexGrid {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    list-style: none;
    margin: 0 0 -1.5em -1.5em;
    padding: 0;
}
.FlexGrid-item {
    -webkit-box-flex: 1;
    -ms-flex: 1 0 calc(100% - 1.5em);
    flex: 1 0 calc(100% - 1.5em);
    margin: 0 0 1.5em 1.5em;
}
.Titles {
    font-weight: 300;
    line-height: 1.2;
    margin: 0 0 1.5em;
}
.Titles-main, .Titles-sub {
    color: inherit;
    font: inherit;
    margin: 0;
}
.Titles-main {
    font-size: 1.4em;
}
.Titles-sub {
    opacity: .6;
    margin-top: .2em;
}
.FlexGrid-item--fixed {
    -webkit-box-flex: 0 !important;
    -ms-flex: 0 0 auto !important;
    flex: 0 0 auto !important;
}
.ActiveUsers {
    background: #f4f2f1;
    border: 1px solid #d4d2d0;
    border-radius: 4px;
    font-weight: 300;
    padding: .5em 1.5em;
    white-space: nowrap;
}
.ActiveUsers-value {
    display: inline-block;
    font-weight: 600;
    margin-right: -.25em;
}
.ViewSelector, .ViewSelector2 {
    display: block;
}
.ViewSelector2-item, .ViewSelector table {
    display: block;
    margin-bottom: 1em;
    width: 100%;
}
.ViewSelector2-item > label, .ViewSelector td:first-child {
    font-weight: 700;
    margin: 0 .25em .25em 0;
    display: block;
}
.FormField {
    width: 100%;
}
.Chartjs-figure {
    height: 250px;
}

input.FormField, select.FormField, textarea.FormField {
    background: #fff;
    border: 1px solid #d4d2d0;
    border-radius: 4px;
    box-sizing: border-box;
    font: inherit;
    font-weight: 400;
    height: 2.42857em;
    line-height: 1.42857em;
    padding: 0.42857em;
    transition: border-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.ViewSelector2-item > select {
    width: 100%;
}
.FlexGrid--halves .FlexGrid-item {
    -ms-flex-preferred-size: 34%;
    flex-basis: 34%;
}
.Chartjs {
    font-size: .85em;
}
.Chartjs-legend {
    list-style: none;
    margin: 0;
    padding: 1em 0 0;
    text-align: center;
}
.Chartjs-legend > li {
    display: inline-block;
    padding: .25em .5em;
}
.Chartjs-legend > li > i {
    display: inline-block;
    height: 1em;
    margin-right: .5em;
    vertical-align: -.1em;
    width: 1em;
}
@media (min-width: 1024px) {
    .Dashboard, .Dashboard-header {
        padding: 2em;
    }
    .Dashboard-footer, .Dashboard-header {
        margin: -2em -2em 2em;
    }
    .FlexGrid {
        margin: 0 0 -2em -2em;
    }
    .FlexGrid-item {
        margin: 0 0 2em 2em;
    }
    .FlexGrid-item {
        margin: 0 0 2em 2em;
    }
}
@media (min-width: 570px) {
    .FlexGrid-item {
        -ms-flex-preferred-size: 200px;
        flex-basis: 200px;
    }
    .FlexGrid-item {
        -ms-flex-preferred-size: 200px;
        flex-basis: 200px;
    }
    .ViewSelector, .ViewSelector2 {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: 0 0 -1em -1em;
        width: calc(100% + 1em);
    }
    .ViewSelector2-item, .ViewSelector table {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 calc(100%/3 - 1em);
        flex: 1 1 calc(100%/3 - 1em);
        margin-left: 1em;
    }
    .Chartjs-figure {
        margin-right: 1.5em;
    }
}
</style>