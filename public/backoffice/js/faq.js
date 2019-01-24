/**
 * CMS (plugins summernote)
 */
$(function () {
    $('#dit_service_metiermanagerbundle_faq_translations_fr_faqtQuestion, #dit_service_metiermanagerbundle_faq_translations_fr_faqttResponse').summernote({
        lang: 'fr-FR',
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });

    $('#dit_service_metiermanagerbundle_faq_translations_en_faqtQuestion, #dit_service_metiermanagerbundle_faq_translations_en_faqttResponse').summernote({
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });
})
