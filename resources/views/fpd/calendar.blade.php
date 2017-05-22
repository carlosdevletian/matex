<div slot="category" class="fpd-product" title="{{ $category->name }}">
    <img src="{{ $category->template() }}"
        title="Base template"
        data-parameters=
            '{
                "draggable": false,
                "x": 600,
                "y" : 320,
                "removable": false,
                "zChangeable": false,
                "colors": [],
                "z": 2
            }'
    />
    <span
        title="Dates"
        data-parameters=
            '{
                "x": 602,
                "y" : 90,
                "draggable": true,
                "copyable": true,
                "resizable" : true,
                "removable": true,
                "zChangeable": false,
                "fontSize": 14,
                "colors": []
            }'
    >YEAR GOES HERE</span>
     @for ($i = 0; $i < 12; $i++) 
        <span
        title="Dates"
        data-parameters=
            '{
                "x": {{ get_x_coordinates($i) }},
                "y" : {{  get_y_coordinates($i) }},
                "draggable": true,
                "copyable": true,
                "resizable" : true,
                "removable": true,
                "zChangeable": false,
                "fontSize": 7,
                "colors": []
            }'
    >{{ month($i+1) }}
S   M   T   W   T   F   S
1    2    3    4   5    6   7
8    9   10  11 12  13 14
15  16 17  18 19  20 21
22  23 24  25 26  27 28
29  30</span>

     @endfor 
    
</div>
