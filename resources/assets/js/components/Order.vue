<template>
    <div>
        <table class="table">
        <thead>
            <tr>
                <th>Subtotal</th>
                <th>Shipping</th>
                <th>Tax</th>
                <th>Total</th>
            </tr>
        </thead>
            <tbody>
                <tr>
                    <td>{{ subtotal }}</td>
                    <td>{{ shipping }}</td>
                    <td>{{ tax }}</td>
                    <td>{{ total }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        computed: {
            subtotal: function() {
                var sum = 0;
                this.items.forEach( function(item){ 
                    sum += item.total_price; 
                });
                return sum;
            },
            shipping: function() {
                return 20;
            },
            tax: function() {
                return (this.subtotal + this.shipping) * (0.12);
            },
            total: function() {
                return (this.subtotal + this.shipping + this.tax);
            }
        }
    }
</script>