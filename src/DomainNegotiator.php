<?php

namespace Drupal\domain_config_ui;

use Drupal\domain\DomainNegotiator as Negotiator;

/**
 * {@inheritdoc}
 */
class DomainNegotiator extends Negotiator {
  /**
   * Determine the active domain.
   */
  protected function negotiateActiveDomain() {
    // Set http host to be that of the selected domain to configure.
    if ($selected_domain = $this->getSelectedDomain()) {
      $httpHost = $selected_domain->getHostname();
    }
    else {
      $httpHost = $this->negotiateActiveHostname();
    }
    $this->setRequestDomain($httpHost);
    return $this->domain;
  }

  /**
   * Get the selected domain.
   */
  public function getSelectedDomain() {
    $selected_domain_id = $this->getSelectedDomainId();
    if ($selected_domain_id
      && $selected_domain = $this->domainStorage->load($selected_domain_id)) {
      return $selected_domain;
    }
  }

  /**
   * Get the selected domain ID.
   */
  public function getSelectedDomainId() {
    // Return selected domain ID on admin paths only.
    return !empty($_SESSION['domain_config_ui']['config_save_domain']) ?
      $_SESSION['domain_config_ui']['config_save_domain'] : '';
  }

  /**
   * Set the current selected domain ID.
   *
   * @param string $domain_id
   */
  public function setSelectedDomain($domain_id) {
    if ($domain = $this->domainStorage->load($domain_id)) {
      $_SESSION['domain_config_ui']['config_save_domain'] = $domain_id;
    }
    else {
      $_SESSION['domain_config_ui']['config_save_domain'] = '';
    }
  }
}