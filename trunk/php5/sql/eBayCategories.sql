USE [EWS]
GO

/****** Object:  Table [dbo].[eBayCategories]    Script Date: 09/26/2012 23:07:25 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[eBayCategories](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[EnvironmentID] [int] NOT NULL,
	[SiteID] [int] NOT NULL,
	[CategoryID] [nvarchar](32) NOT NULL,
	[AutoPayEnabled] [int] NULL,
	[CatalogEnabled] [int] NULL,
	[CategoryLevel] [int] NULL,
	[CategoryName] [nvarchar](32) NULL,
	[CategoryParentID] [nvarchar](32) NULL,
	[Expired] [int] NULL,
	[LeafCategory] [int] NULL,
	[Virtual] [int] NULL,
	[CSTList] [ntext] NULL,
	[B2BVatEnabled] [int] NULL,
	[CategoryParentName] [nvarchar](64) NULL,
	[ProductFinderID] [int] NULL,
	[ProductFinderIDs] [nvarchar](64) NULL,
	[ProductSearchPageAvailable] [int] NULL,
	[ProductFinderAvailable] [int] NULL,
	[IntlAutosFixedCat] [int] NULL,
	[NumOfItems] [int] NULL,
	[SellerGuaranteeEligible] [int] NULL,
	[ORPA] [int] NULL,
	[ORRA] [int] NULL,
	[LSD] [int] NULL,
 CONSTRAINT [PK_eBay_categories] PRIMARY KEY NONCLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

ALTER TABLE [dbo].[eBayCategories]  WITH CHECK ADD  CONSTRAINT [FK_eBayCategories_eBayEnvironment] FOREIGN KEY([EnvironmentID])
REFERENCES [dbo].[eBayEnvironment] ([ID])
GO

ALTER TABLE [dbo].[eBayCategories] CHECK CONSTRAINT [FK_eBayCategories_eBayEnvironment]
GO

