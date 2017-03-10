<modal-contact v-if="showContactModal" @close="closeContactModal()"></modal-contact>
<modal-image :design="design" v-if="showImageModal" @close="closeImageModal()"></modal-image>