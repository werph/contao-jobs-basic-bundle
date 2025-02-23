<?php

declare(strict_types=1);

/**
 * Plenta Jobs Basic Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2022, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

namespace Plenta\ContaoJobsBasic\EventListener\Contao\DCA;

use Contao\CoreBundle\Slug\Slug;
use Contao\DataContainer;
use Contao\Input;
use Contao\StringUtil;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Plenta\ContaoJobsBasic\Entity\TlPlentaJobsBasicJobLocation;
use Plenta\ContaoJobsBasic\Entity\TlPlentaJobsBasicOffer as TlPlentaJobsBasicOfferEntity;
use Plenta\ContaoJobsBasic\Helper\EmploymentType;

class TlModule
{
    protected ManagerRegistry $registry;

    public function __construct(
        ManagerRegistry $registry
    ) {
        $this->registry = $registry;
    }

    public function jobLocationOptionsCallback(): array
    {
        $jobLocationRepository = $this->registry->getRepository(TlPlentaJobsBasicJobLocation::class);

        $jobLocations = $jobLocationRepository->findAll();

        $return = ['remote' => $GLOBALS['TL_LANG']['MSC']['PLENTA_JOBS']['remote']];
        foreach ($jobLocations as $jobLocation) {
            $return[$jobLocation->getId()] = $jobLocation->getOrganization()->getName().': '.$jobLocation->getStreetAddress();

            if ('' !== $jobLocation->getAddressLocality()) {
                $return[$jobLocation->getId()] .= ', '.$jobLocation->getAddressLocality();
            }
        }

        return $return;
    }
}
