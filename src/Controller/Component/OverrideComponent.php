<?php
namespace Override\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class OverrideComponent extends Component
{
    /**
     * Constructor hook method. Set models.
     *
     * @param array $config The configuration settings provided to this component.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->setModels(Configure::read('Overrides.models'));
    }

    /**
     * Overload models
     *
     * @param array $models
     */
    public function setModels(array $models)
    {
        foreach ($models as $alias => $options) {
            $this->setModel($alias, $options);
        }
    }

    /**
     * Overload model
     *
     * @param string $alias Name of the alias
     * @param array $options list of options for the alias
     * @return array The config data.
     */
    public function setModel($alias, $options = [])
    {
        return TableRegistry::config($alias, $options);
    }
}
