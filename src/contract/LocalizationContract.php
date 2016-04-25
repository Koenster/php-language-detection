<?php namespace koenster\PHPLanguageDetection\contract;

interface LocalizationContract {

    /**
     * @author Koen Blokland Visser
     *
     * @return string Detected localization (example nl-NL)
     */
    public function detect();

    /**
     * @author Koen Blokland Visser
     *
     * @return array Populates the provided preferences to match with the application settings
     *
     * @param $preferences string The setting for localization
     */
    public function preferences($preferences);

    /**
     * @author Koen Blokland Visser
     *
     * @return boolean|string If none matched a bool, if matched a string (example nl-NL)
     */
    public function match();

    /**
     * @author Koen Blokland Visser
     *
     * @param $preferences string The setting for localization
     *
     * @return $this
     */
    public function setPreferences($preferences);

    /**
     * @author Koen Blokland Visser
     *
     * @param $available array Available array of locales/languages
     *
     * @return $this
     */
    public function setAvailable(array $available);

    /**
     * @author Koen Blokland Visser
     *
     * @param $default string Default locale
     *
     * @return $this
     */
    public function setDefault($default);
}