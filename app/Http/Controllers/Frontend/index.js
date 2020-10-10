import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home.vue";
import Programs from "../views/Programs.vue";
import Login from "../views/Login.vue";
import ForgotPassword from "../views/ForgotPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Register from "../views/Register.vue";
import Program from "../views/Program.vue";
import Entre from "../views/Entre.vue";
import OnlineApplication from "../views/OnlineApplication.vue";
import MembershipApplication from "../views/MembershipApplication.vue";
import InstructorApplication from "../views/InstructorApplication.vue";
import TrainingApplication from "../views/TrainingApplication.vue";
import ExperienceApplication from "../views/ExperienceApplication.vue";
import OurCertificate from "../views/OurCertificate.vue";
import Instructor from "../views/Instructor.vue";
import Experience from "../views/Experience.vue";
import TrainingCenter from "../views/TrainingCenter.vue";
import Membership from "../views/Membership.vue";
import Privacy from "../views/Privacy.vue";
import Accreditation from "../views/Accreditation.vue";
import Accreditation2 from "../views/Accreditation2.vue";
import Accreditation3 from "../views/Accreditation3.vue";
import Accreditation4 from "../views/Accreditation4.vue";
import Corporate from "../views/Corporate.vue";
import News from "../views/News.vue";
import MainCertificate from "../views/MainCertificate.vue";
import CertificateAchievement from "../views/CertificateAchievement.vue";
import ContactUs from "../views/ContactUs.vue";
import VerficationAccount from "../views/VerficationAccount.vue";
import OnlineTraining from "../views/OnlineTraining.vue";
import Events from "../views/Events.vue";
import Faq from "../views/Faq.vue";
import Profile from "../views/Profile.vue";
import Logout from "../views/Logout.vue";
import NavbarPage from "../views/NavbarPage.vue";

Vue.use(VueRouter);

const routes = [
  
  // My Routes

  // Auth
  {
    path: "/register",
    name: "register",
    component: require("../views/Auth/Register.vue").default,
  },
  {
    path: "/verify",
    name: "verify",
    component: require("../views/Auth/Verify.vue").default,
  },
  {
    path: "/reset-password",
    name: "reset",
    component: require("../views/Auth/Reset.vue").default,
  },
  {
    path: "/forgot-password",
    name: "forgot",
    component: require("../views/Auth/Forget.vue").default,
  },
  {
    path: "/login",
    name: "login",
    component: require("../views/Auth/Login.vue").default,
  },
  {
    path: "/logout",
    name: "logout",
    component: require("../views/Logout.vue").default,
  },
  {
    path: "/me/profile",
    name: "myProfile",
    component: require("../views/Auth/Profile.vue").default,
  },
  {
    path: "/me/certificate",
    name: "myCertificate",
    component: require("../views/Auth/MyCertificate.vue").default,
  },
  {
    path: "/me/certificate-achievement",
    name: "myCertificateAchievement",
    component: require("../views/Auth/MyAchievement.vue").default,
  },


  

  // Home
  {
    path: "/",
    name: "home",
    component: require("../views/Home/List.vue").default,
  },

  // Popular Search
  {
    path: "/popular-search/:slug",
    name: "show-popular-search",
    component: require("../views/PopularSearchs/Show.vue").default,
  },
  {
    path: "/popular-search/shortcut/:slug",
    name: "shortcut-popular-search",
    component: require("../views/PopularSearchs/Shortcut.vue").default,
  },
  {
    path: "/popular-search/in/program/:slug",
    name: "program-popular-search",
    component: require("../views/PopularSearchs/ShowProgram.vue").default,
  },

  // Accreditations
  {
    path: "/accreditations",
    name: "accreditations",
    component: require("../views/Accreditations/Show.vue").default,
  },
  {
    path: "/accreditations/:slug",
    name: "show-accreditations",
    component: require("../views/Accreditations/Show.vue").default,
  },

  // Programs
  {
    path: "/programs",
    name: "programs",
    component: require("../views/Programs/List.vue").default,
  },
  {
    path: "/programs/sectors/:slug",
    name: "sector-programs",
    component: require("../views/Programs/Sector.vue").default,
  },
  {
    path: "/programs/sectors/in/:slug",
    name: "program-detail-programs",
    component: require("../views/Programs/ShowProgram.vue").default,
  },


  {
    path: "/online-applications/:slug",
    name: "online-applications",
    component: require("../views/Programs/Application.vue").default,
  },
  // Certifications
  {
    path: "/our-certificates",
    name: "certificates",
    component: require("../views/Certificate/List.vue").default,
  },
  {
    path: "/certificates/program/:slug",
    name: "program-detail-certificates",
    component: require("../views/Certificate/ShowProgram.vue").default,
  },


  // Membership
  {
    path: "/memberships",
    name: "memberships",
    component: require("../views/Memberships/List.vue").default,
  },
  {
    path: "/memberships/:slug",
    name: "show-memberships",
    component: require("../views/Memberships/Show.vue").default,
  },

  // About
  {
    path: "/about",
    name: "about",
    component: require("../views/About/Show.vue").default,
  },

  // Contact Us
  {
    path: "/contact",
    name: "contact",
    component: require("../views/Contacts/List.vue").default,
  },

  // Pages
  {
    path: "/page/:slug",
    name: "show-page",
    component: require("../views/Pages/Show.vue").default,
  },

  // Privacy
  {
    path: "/privacy",
    name: "privacy",
    component: require("../views/Privacy/List.vue").default,
  },

  // FAQS
  {
    path: "/faq",
    name: "faq",
    component: require("../views/Faq/List.vue").default,
  },

  // Events
  {
    path: "/events",
    name: "events",
    component: require("../views/Events/Show.vue").default,
  },

  // Online Trainings
  {
    path: "/online-trainings",
    name: "online-trainings",
    component: require("../views/OnlineTrainings/Show.vue").default,
  },
  {
    path: "/online-trainings/:slug",
    name: "show-online-trainings",
    component: require("../views/OnlineTrainings/Show.vue").default,
  },
];

const router = new VueRouter({
  mode: 'history',
  base: '/',
  fallback: true,
  routes,
});

export default router;
