import { createRouter, createWebHistory } from "vue-router";

import PersonInfosIndex from "../components/personinfos/PersonInfosIndex.vue";
import PersonInfosCreate from "../components/personinfos/PersonInfosCreate.vue";
import PersonInfosEdit from "../components/personinfos/PersonInfosEdit.vue";
import UsersIndex from "../components/users/UsersIndex.vue";
import UsersCreate from "../components/users/UsersCreate.vue";
import UsersEdit from "../components/users/UsersEdit.vue";
import ActivityIndex from "../components/activities/ActivityIndex.vue";
import ActivityCreate from "../components/activities/ActivityCreate.vue";
import ActivityEdit from "../components/activities/ActivityEdit.vue";
import GadActivitiesIndex from "../components/gadactivities/GadActivitiesIndex.vue";
import GadActivitiesCreate from "../components/gadactivities/GadActivitiesCreate.vue";
import ActivityDetailsIndex from "../components/activitydetails/ActivityDetailsIndex.vue";
import ActivityDetailsCreate from "../components/activitydetails/ActivityDetailsCreate.vue";
import ActivityDetailsEdit from "../components/activitydetails/ActivityDetailsEdit.vue";
import ActivityDetailsUpdateAccom from "../components/activitydetails/ActivityDetailsUpdateAccom.vue";
import AttendeesIndex from "../components/activities/AttendeesIndex.vue";
import AttendeesCreate from "../components/activities/AttendeesCreate.vue";
import AttendeesEdit from "../components/activities/AttendeesEdit.vue";
import CommitteePositionsIndex from "../components/committeepositions/CommitteePositionsIndex.vue";
import CommitteePositionsCreate from "../components/committeepositions/CommitteePositionsCreate.vue";
import CommitteePositionsEdit from "../components/committeepositions/CommitteePositionsEdit.vue";
import CommitteesIndex from "../components/committees/CommitteesIndex.vue";
import CommitteesCreate from "../components/committees/CommitteesCreate.vue";
import CommitteesEdit from "../components/committees/CommitteesEdit.vue";
import PlanBudgetsIndex from "../components/planbudgets/PlanBudgetsIndex.vue";
import PlanBudgetsCreate from "../components/planbudgets/PlanBudgetsCreate.vue";
import PlanBudgetsEdit from "../components/planbudgets/PlanBudgetsEdit.vue";
import FrontlineServicesIndex from "../components/frontlineservices/FrontlineServicesIndex.vue";
import FrontlineServicesCreate from "../components/frontlineservices/FrontlineServicesCreate.vue";
import FrontlineServicesEdit from "../components/frontlineservices/FrontlineServicesEdit.vue";
import GoalsIndex from "../components/goals/GoalsIndex.vue";
import GoalsCreate from "../components/goals/GoalsCreate.vue";
import GoalsEdit from "../components/goals/GoalsEdit.vue";
import GenderIssuesIndex from "../components/genderissues/GenderIssuesIndex.vue";
import GenderIssuesCreate from "../components/genderissues/GenderIssuesCreate.vue";
import GenderIssuesEdit from "../components/genderissues/GenderIssuesEdit.vue";
import CauseGenderIssuesIndex from "../components/causegenderissues/CauseGenderIssuesIndex.vue";
import CauseGenderIssuesCreate from "../components/causegenderissues/CauseGenderIssuesCreate.vue";
import CauseGenderIssuesEdit from "../components/causegenderissues/CauseGenderIssuesEdit.vue";
import ObjectivesIndex from "../components/objectives/ObjectivesIndex.vue";
import ObjectivesCreate from "../components/objectives/ObjectivesCreate.vue";
import ObjectivesEdit from "../components/objectives/ObjectivesEdit.vue";
import FrontlineServiceTypesIndex from "../components/frontlineservicetypes/FrontlineServiceTypesIndex.vue";
import FrontlineServiceTypesCreate from "../components/frontlineservicetypes/FrontlineServiceTypesCreate.vue";
import FrontlineServiceTypesEdit from "../components/frontlineservicetypes/FrontlineServiceTypesEdit.vue";
import PermitTypesIndex from "../components/permittypes/PermitTypesIndex.vue";
import PermitTypesCreate from "../components/permittypes/PermitTypesCreate.vue";
import PermitTypesEdit from "../components/permittypes/PermitTypesEdit.vue";

const routes = [
    {
        path: '/personinfos',
        name: 'personinfos.index',
        component: PersonInfosIndex,
        meta: {
            title: 'Personnel'
        }
    },
    {
        path: '/personinfos/create',
        name: 'personinfos.create',
        component: PersonInfosCreate
    },
    {
        path: '/personinfos/:id/edit',
        name: 'personinfos.edit',
        component: PersonInfosEdit,
        props: true
    },
    {
        path: '/committees',
        name: 'committees.index',
        component: CommitteesIndex,
        meta: {
            title: 'GAD Committees'
        }
    },
    {
        path: '/committees/create',
        name: 'committees.create',
        component: CommitteesCreate
    },
    {
        path: '/committees/:id/edit',
        name: 'committees.edit',
        component: CommitteesEdit,
        props: true
    },
    {
        path: '/planbudgets',
        name: 'planbudgets.index',
        component: PlanBudgetsIndex,
        meta: {
            title: 'GAD Plan and Budget'
        }
    },
    {
        path: '/planbudgets/create',
        name: 'planbudgets.create',
        component: PlanBudgetsCreate
    },
    {
        path: '/planbudgets/:id/edit',
        name: 'planbudgets.edit',
        component: PlanBudgetsEdit,
        props: true
    },
    {
        path: '/pages/gadactivities/show/:ga_id',
        name: 'gadactivities.index',
        component: GadActivitiesIndex,
        props: true,
        meta: {
            title: 'GAD Activities'
        }
    },
    {
        path: '/pages/gadactivities/create/:planbudget_id',
        name: 'gadactivities.create',
        component: GadActivitiesCreate,
        props: true
    },
    {
        path: '/activitydetails/show/:ga_id',
        name: 'activitydetails.index',
        component: ActivityDetailsIndex,
        props: true,
        meta: {
            title: 'Activity Details'
        }
    },
    {
        path: '/activitydetails/create/:ga_id',
        name: 'activitydetails.create',
        component: ActivityDetailsCreate,
        props: true,
    },
    {
        path: '/activitydetails/:id/edit/:ga_id',
        name: 'activitydetails.edit',
        component: ActivityDetailsEdit,
        props: true
    },
    {
        path: '/activitydetails/:id/updateaccom/:ga_id',
        name: 'activitydetails.updateaccom',
        component: ActivityDetailsUpdateAccom,
        props: true
    },
    {
        path: '/activities',
        name: 'activities.index',
        component: ActivityIndex,
        meta: {
            title: 'Personnel'
        }
    },
    {
        path: '/activities/create',
        name: 'activities.create',
        component: ActivityCreate
    },
    {
        path: '/activities/:id/edit',
        name: 'activities.edit',
        component: ActivityEdit,
        props: true
    },
    {
        path: '/activities/:id/attendees',
        name: 'activities.attendees',
        component: AttendeesIndex,
        props: true
    },
    {
        path: '/activities/:id/attendees/create',
        name: 'attendees.create',
        component: AttendeesCreate,
        props: true
    },
    {
        path: '/activities/:id/attendees/edit/:person_info_id',
        name: 'attendees.edit',
        component: AttendeesEdit,
        props: true
    },
    {
        path: '/frontlineservices',
        name: 'frontlineservices.index',
        component: FrontlineServicesIndex,
        meta: {
            title: 'Frontline Services Data'
        }
    },
    {
        path: '/frontlineservices/create',
        name: 'frontlineservices.create',
        component: FrontlineServicesCreate
    },
    {
        path: '/frontlineservices/:id/edit',
        name: 'frontlineservices.edit',
        component: FrontlineServicesEdit,
        props: true
    },
    {
        path: '/users',
        name: 'users.index',
        component: UsersIndex
    },
    {
        path: '/users/create',
        name: 'users.create',
        component: UsersCreate
    },
    {
        path: '/users/:id/edit',
        name: 'users.edit',
        component: UsersEdit,
        props: true
    },
    {
        path: '/maintenance/committeepositions',
        name: 'committeepositions.index',
        component: CommitteePositionsIndex,
        meta: {
            title: 'Committee Positions'
        }
    },
    {
        path: '/maintenance/committeepositions/create',
        name: 'committeepositions.create',
        component: CommitteePositionsCreate
    },
    {
        path: '/maintenance/committeepositions/:id/edit',
        name: 'committeepositions.edit',
        component: CommitteePositionsEdit,
        props: true
    },
    {
        path: '/maintenance/goals',
        name: 'goals.index',
        component: GoalsIndex,
        meta: {
            title: 'GAD Goals'
        }
    },
    {
        path: '/maintenance/goals/create',
        name: 'goals.create',
        component: GoalsCreate
    },
    {
        path: '/maintenance/goals/:id/edit',
        name: 'goals.edit',
        component: GoalsEdit,
        props: true
    },
    {
        path: '/maintenance/genderissues',
        name: 'genderissues.index',
        component: GenderIssuesIndex,
        meta: {
            title: 'Gedner Issues/ GAD Mandate'
        }
    },
    {
        path: '/maintenance/genderissues/create',
        name: 'genderissues.create',
        component: GenderIssuesCreate
    },
    {
        path: '/maintenance/genderissues/:id/edit',
        name: 'genderissues.edit',
        component: GenderIssuesEdit,
        props: true
    },
    {
        path: '/maintenance/causegenderissues',
        name: 'causegenderissues.index',
        component: CauseGenderIssuesIndex,
        meta: {
            title: 'Causes of Gender Issues'
        }
    },
    {
        path: '/maintenance/causegenderissues/create',
        name: 'causegenderissues.create',
        component: CauseGenderIssuesCreate
    },
    {
        path: '/maintenance/causegenderissues/:id/edit',
        name: 'causegenderissues.edit',
        component: CauseGenderIssuesEdit,
        props: true
    },
    {
        path: '/maintenance/objectives',
        name: 'objectives.index',
        component: ObjectivesIndex,
        meta: {
            title: 'GAD Result Statement/ GAD Objective'
        }
    },
    {
        path: '/maintenance/objectives/create',
        name: 'objectives.create',
        component: ObjectivesCreate
    },
    {
        path: '/maintenance/objectives/:id/edit',
        name: 'objectives.edit',
        component: ObjectivesEdit,
        props: true
    },
    {
        path: '/maintenance/frontlineservicetypes',
        name: 'frontlineservicetypes.index',
        component: FrontlineServiceTypesIndex,
        meta: {
            title: 'Frontline Services'
        }
    },
    {
        path: '/maintenance/frontlineservicetypes/create',
        name: 'frontlineservicetypes.create',
        component: FrontlineServiceTypesCreate
    },
    {
        path: '/maintenance/frontlineservicetypes/:id/edit',
        name: 'frontlineservicetypes.edit',
        component: FrontlineServiceTypesEdit,
        props: true
    },
    {
        path: '/maintenance/permittypes',
        name: 'permittypes.index',
        component: PermitTypesIndex,
        meta: {
            title: 'Frontline Service Types'
        }
    },
    {
        path: '/maintenance/permittypes/create',
        name: 'permittypes.create',
        component: PermitTypesCreate
    },
    {
        path: '/maintenance/permittypes/:id/edit',
        name: 'permittypes.edit',
        component: PermitTypesEdit,
        props: true
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
});