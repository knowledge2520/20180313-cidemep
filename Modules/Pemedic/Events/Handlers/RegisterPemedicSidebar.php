<?php

namespace Modules\Pemedic\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterPemedicSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
//             $group->item(trans('pemedic::pemedics.title.pemedics'), function (Item $item) {
//                 $item->icon('fa fa-copy');
//                 $item->weight(10);
//                 $item->authorize(
//                      /* append */
//                 );
//                 $item->item(trans('pemedic::pemedics.title.pemedics'), function (Item $item) {
//                     $item->icon('fa fa-copy');
//                     $item->weight(0);
//                     $item->append('admin.pemedic.pemedic.create');
//                     $item->route('admin.pemedic.pemedic.index');
//                     $item->authorize(
//                         $this->auth->hasAccess('pemedic.pemedics.index')
//                     );
//                 });
// // append

//             });


            // sidebar clinic profile
            $group->item(trans('pemedic::clinics.title.clinics'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('pemedic::clinics.title.clinics'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.clinic.clinic.create');
                    $item->route('admin.clinic.clinic.index');
                    $item->authorize(
                        $this->auth->hasAccess('clinic.clinics.index')
                    );
                });
            });

            // sidebar patient profile
            $group->item(trans('pemedic::patients.title.patients'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('pemedic::patients.title.patients'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.patient.patient.create');
                    $item->route('admin.patient.patient.index');
                    $item->authorize(
                        $this->auth->hasAccess('patient.patients.index')
                    );
                });
            });

            // sidebar doctor profile
            $group->item(trans('pemedic::doctors.title.doctors'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('pemedic::doctors.title.doctors'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.doctor.doctor.create');
                    $item->route('admin.doctor.doctor.index');
                    $item->authorize(
                        $this->auth->hasAccess('doctor.doctors.index')
                    );
                });
            });

            // sidebar doctor profile
            $group->item(trans('pemedic::medicals.title.medicals'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('pemedic::medicals.title.medicals'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.medical.medical.create');
                    $item->route('admin.medical.medical.index');
                    $item->authorize(
                        $this->auth->hasAccess('medical.medicals.index')
                    );
                });
            });
            
            // sidebar news 
            $group->item(trans('pemedic::news.title.news'), function (Item $item) {
                $item->icon('fa fa-copy');
                    $item->weight(12);
                    $item->route('admin.new.new.index');
                    $item->authorize(
                        $this->auth->hasAccess('new.news.index')
                    );
            });

        });
        return $menu;
    }
}
