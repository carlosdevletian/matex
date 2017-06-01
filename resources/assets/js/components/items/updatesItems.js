export const updatesItems = {
    data: function() {
        return {
            error: '',
            processing: false,
            showModal: false
        }
    },
    methods: {
        updateItem: function () {
            this.processing = true;
            if(! this.quantityIsValid()) {
                this.error = 'Please input a valid quantity';
                this.item.quantity = 1;
            } else {
                this.error = '';
            }
            var itemId = this.item.id ? this.item.id : '';
            axios.put(`/items/${itemId}`, {
                item: this.item
            }).then((response) => {
                this.$emit('item-updated', response.data.item);
                Event.$emit('item-updated', response.data.item);
                this.processing = false;
            });
        },
        deleteItem: function() {
            this.processing = true;
            var id = this.item.id ? this.item.id : this.item.product.id;
            this.$emit('delete-item', id);
            this.processing = false;
        },
        quantityIsValid: function() {
            return (this.item.quantity > 0 && this.item.quantity % 1 == 0);
        },
        productName: function() {
            return `${this.item.product.name.charAt(0).toUpperCase()}${this.item.product.name.slice(1)}`;
        },
        addAccessory: function() {
            this.showModal = true;
        },
        assignAccessory(accessory) {
            var item = this.item;
            if(accessory != null) {
                item.accessory_id = accessory.id;
                item.accessory = accessory;
            } else {
                delete item['accessory_id']; 
                delete item['accessory']; 
            }
            this.$emit('item-updated', item);
        }
    }
}
