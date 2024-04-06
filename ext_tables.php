<?php
defined('TYPO3') || die();

(static function() {

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gdprextensionscombm_domain_model_localbanner', 'EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_csh_tx_gdprextensionscombm_domain_model_localbanner.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gdprextensionscombm_domain_model_localbanner');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gdprextensionscombm_domain_model_bannerstat', 'EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_csh_tx_gdprextensionscombm_domain_model_bannerstat.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gdprextensionscombm_domain_model_bannerstat');
})();
