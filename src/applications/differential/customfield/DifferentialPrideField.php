<?php

/**
 * Custom field for Coursera to allow authors
 * to specify how proud they are of a revision
 */
final class DifferentialPrideField
  extends DifferentialStoredCustomField {

  private $error;

  public function getFieldKey() {
    return 'phabricator:coursera-pride';
  }

  public function getFieldKeyForConduit() {
    return 'courseraPride';
  }

  public function isFieldEnabled() {
    return true;
  }

  public function canDisableField() {
    return false;
  }

  public function getFieldName() {
    return pht('#AreYouProud');
  }

  public function getFieldDescription() {
    return pht('Is the author proud of this revision?');
  }

  public function shouldAppearInPropertyView() {
    return true;
  }

  public function renderPropertyViewLabel() {
    return $this->getFieldName();
  }

  public function renderPropertyViewValue(array $handles) {
    return $this->getValue();
  }

  public function shouldAppearInEditView() {
    return true;
  }

  public function readValueFromRequest(AphrontRequest $request) {
    $this->setValue($request->getStr($this->getFieldKey()));
    return $this;
  }

  public function renderEditControl(array $handles) {
    return id(new AphrontFormTextControl())
      ->setLabel(pht('Are you proud of this revision?'))
      ->setCaption(
        pht('#AreWeProud'))
      ->setName($this->getFieldKey())
      ->setValue(implode(', ', nonempty($this->getValue(), array())))
      ->setError($this->error);
  }

  public function shouldAppearInCommitMessage() {
    return true;
  }

  public function shouldAppearInCommitMessageTemplate($revision) {
    return true;
  }

  public function getCommitMessageLabels() {
    return array(
      ''
    );
  }

  public function parseValueFromCommitMessage($value) {
    return $value;
  }

  public function readValueFromCommitMessage($value) {
    $this->setValue($value);
    return $this;
  }

  public function renderCommitMessageValue(array $handles) {
    $value = $this->getValue();
    if (!$value) {
      return null;
    }
    return $value;
  }

}
